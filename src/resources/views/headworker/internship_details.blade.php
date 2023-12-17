<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-8Bl9kEdA9lCm0OSNYAnleCqZIDbhUVJ-0AC1rADdHvy2QIwMz8TnMa2AI5O3ukbzNhC2/GfQlZGpzQP9LrYGGg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" href="{{ asset('images/logo_2.png') }}" type="image/png">
    <title>Prax</title>
    <script src="https://kit.fontawesome.com/361bfee177.js" crossorigin="anonymous"></script>
    <script>
            document.addEventListener('DOMContentLoaded', function () {
                const menuIcon = document.querySelector('.menu-icon');
                const navLinks = document.querySelector('.nav-links');
                const container = document.querySelector('.container');

                menuIcon.addEventListener('click', function () {
                    navLinks.classList.toggle('show');
                    container.classList.toggle('show-menu');
                });
            });
    </script>
@if($role == 'Vedúci pracoviska')
    <style>
        :root {
            --link-count: 5;
        }
    </style>
@endif
</head>

<body>

    <nav class="navbar">
        <a href="{{ route('dashboard') }}">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="nav-logo">
        </a>
        <i class="fa-solid fa-bars menu-icon" style="color: #000205;"></i>
        <ul class="nav-links">
            <li><a href="{{ route('dashboard') }}">Domov</a></li>
            @if($role == 'Vedúci pracoviska')
                <li><a href="{{ route('headworker.internship_details') }}">Prax</a></li>
                <li><a href="{{ route('headworker.company') }}">Firma</a></li>
                <li><a href="{{ route('headworker.report') }}">Výkaz</a></li>
                <li><a href="{{ route('headworker.feedback') }}">Spätná väzba</a></li>
            @endif
        </ul>

        <div class="user-actions">
            <a href="{{ route('profile.index') }}"><img src="{{ asset('images/user_icon.png') }}" alt="User Icon" class="user-icon"></a>
            <div class="logout-button">
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button type="submit">Odhlásiť sa</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container">
        @if($errors->any())
            @foreach($errors->all() as $error)
                <div class="alert alert-danger" role="alert">
                    <i class="fas fa-minus-circle alert__icon"></i>  {{ $error }}
                </div>
            @endforeach
        @endif

        @if(session('success'))
            <div class="alert alert-success" role="alert">
                <i class="fas fa-check-circle alert__icon"></i>  {{ session('success') }}
            </div>
        @endif

        @if($praxe->count() == 0)
            <div class="alert alert-danger" role="alert">
                <i class="fas fa-minus-circle alert__icon"></i>  Žiadne praxe na zobrazenie.
            </div>
        @else
            <h1>Prax</h1>
            <hr>

            @foreach (['vytvorená', 'prebiehajúca', 'archivovaná'] as $status)
                @php
                    $internshipsForStatus = $praxe->where('aktualny_stav', $status);
                @endphp

                @if($internshipsForStatus->count() > 0)
                    <h2>{{ ucfirst($status) }}</h2>
                    <ul>
                        @foreach ($internshipsForStatus as $prax)
                            <li>
                                <form method="post" action="{{ route('headworker.internship_details.update_status') }}">
                                    @csrf
                                    <a href="{{ route('headworker.internship_show', $prax->id) }}"">ID_{{ $prax->id }}</a> - {{ $prax->student->meno }} {{ $prax->student->priezvisko }}
                                    <input type="hidden" name="prax_id" value="{{ $prax->id }}">
                                    <select name="stav" id="stav" style="width: auto;">
                                        @foreach(['vytvorená', 'archivovaná', 'prebiehajúca'] as $state)
                                            <option value="{{ $state }}" {{ $prax->aktualny_stav == $state ? 'selected' : '' }}>
                                                {{ $state }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <input type="hidden" name="action" value="save_status">
                                    <button type="submit">Uložiť stav</button>
                                </form>

                                <form method="post" action="{{ route('headworker.internship_details.update_worker') }}" style="padding-left:138px;">
                                    @csrf
                                    <input type="hidden" name="prax_id" value="{{ $prax->id }}">
                                    <select name="worker_id" id="worker_id" style="width: auto;">
                                        @foreach($workers as $worker)
                                            <option value="{{ $worker->id }}" {{ $prax->worker->id == $worker->id ? 'selected' : '' }}>
                                                {{ $worker->meno }} {{ $worker->priezvisko }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <input type="hidden" name="action" value="save_worker">
                                    <button type="submit">Uložiť pracovníka</button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                @endif
            @endforeach
        @endif
    </div>

</body>

</html>