<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-8Bl9kEdA9lCm0OSNYAnleCqZIDbhUVJ-0AC1rADdHvy2QIwMz8TnMa2AI5O3ukbzNhC2/GfQlZGpzQP9LrYGGg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" href="{{ asset('images/logo_2.png') }}" type="image/png">
    <title>Zmluvy</title>
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
@if($role == 'admin')
    <style>
        :root {
            --link-count: 10;
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
            <li><a href="{{ route('user_role.index') }}">Role používateľov</a></li>
            <li><a href="{{ route('study_program.index') }}">Študijné programy</a></li>
            <li><a href="{{ route('contract.index') }}">Zmluvy</a></li>
            <li><a href="{{ route('documents.index') }}">Dokumenty</a></li>
            <li><a href="{{ route('user.index') }}">Používatelia</a></li>
            <li><a href="{{ route('address.index') }}">Adresy</a></li>
            <li><a href="{{ route('company.index') }}">Firmy</a></li>
            <li><a href="{{ route('school_subject.index') }}">Predmety</a></li>
            <li><a href="{{ route('feedback.index') }}">Feedback</a></li>
            <li><a href="{{ route('prax.index') }}">Prax</a></li>
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
        <h1>Zmluvy</h1>

        @if(session('success'))
            <div class="alert alert-success" role="alert">
                <i class="fas fa-check-circle alert__icon"></i>  {{ session('success') }}
            </div>
        @endif

        <ul>
            @foreach($contracts as $contract)
                <li>
                    {{ $contract->zmluva }} - {{ $contract->company->nazov_firmy }}

                    <form method="get" action="{{ route('contract.show', $contract->id) }}" style="display: inline;">
                        @csrf
                        <button type="submit">Zobraziť</button>
                    </form>

                    <form method="get" action="{{ route('contract.edit', $contract->id) }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="upravit">Upraviť</button>
                    </form>

                    <form method="post" action="{{ route('contract.destroy', $contract->id) }}" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="vymazat">Vymazať</button>
                    </form>
                </li>
                <br>
            @endforeach
        </ul>

        <button id="toggle-form">Pridanie zmluvy</button>
        
        <div id="create-form" style="display: none;">
            <br>
            <form method="post" action="{{ route('contract.store') }}">
                @csrf
                <label for="zmluva">Zmluva</label>
                <input type="text" name="zmluva" required>

                <label for="firma_id">Vybrať firmu:</label>
                <select name="firma_id">
                    @foreach($companies as $company)
                        <option value="{{ $company->id }}">
                            {{ $company->nazov_firmy }}
                        </option>
                    @endforeach
                </select>

                <button type="submit">Pridať</button>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $("#toggle-form").click(function() {
                $("#create-form").toggle();
            });
        });
    </script>

</body>
</html>
