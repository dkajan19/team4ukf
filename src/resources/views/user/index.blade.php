<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-8Bl9kEdA9lCm0OSNYAnleCqZIDbhUVJ-0AC1rADdHvy2QIwMz8TnMa2AI5O3ukbzNhC2/GfQlZGpzQP9LrYGGg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" href="{{ asset('images/logo_2.png') }}" type="image/png">
    <title>Používatelia</title>
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
</head>
<body>

    <nav class="navbar">
        <a href="{{ route('dashboard') }}">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="nav-logo">
        </a>
        <i class="fa-solid fa-bars menu-icon" style="color: #000205;"></i>
        <ul class="nav-links">
            @if($role == 'admin')
                <li><a href="{{ route('dashboard') }}">Domov</a></li>
                <li><a href="{{ route('user_role.index') }}">Role používateľov</a></li>
                <li><a href="{{ route('study_program.index') }}">Študijné programy</a></li>
                <li><a href="{{ route('contract.index') }}">Zmluvy</a></li>
                <li><a href="{{ route('documents.index') }}">Dokumenty</a></li>
                <li><a href="{{ route('user.index') }}">Používatelia</a></li>
                <li><a href="{{ route('address.index') }}">Adresy</a></li>
                <li><a href="{{ route('company.index') }}">Firmy</a></li>
                <li><a href="{{ route('school_subject.index') }}">Predmety</a></li>
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
        <h1>Používateľ</h1><hr>
        @if(session('success'))
            <div class="alert alert-success" role="alert">
                <i class="fas fa-check-circle alert__icon"></i>  {{ session('success') }}
            </div>
        @endif
    
        <ul>
            @php
            $currentRole = null;
            @endphp
            <br>
            @foreach($users->sortBy(function($user) {
                return optional($user->user_roles)->rola;
                }) as $user)
            @if($currentRole != $user->user_roles->rola)
            @if(!is_null($currentRole))
                </ul><br>
            @endif
            
            <h2>{{ $user->user_roles->rola }}</h2>
            <ul>

            @php
                $currentRole = $user->user_roles->rola;
            @endphp
            @endif
            <br>
            <li>
                {{ $user->priezvisko }} - {{ $user->meno }}
                
                <form method="get" action="{{ route('user.show', $user->id) }}" style="display: inline;">
                    @csrf
                    <button type="submit">Zobraziť</button>
                </form>
                
                <form method="get" action="{{ route('user.edit', $user->id) }}" style="display: inline;">
                    @csrf
                    <button type="submit">Upraviť</button>
                </form>
                
                <form method="post" action="{{ route('user.destroy', $user->id) }}" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Vymazať</button>
                </form>
            </li>
            @endforeach
        </ul>
        <br><br>
    
        <button id="toggle-form">Pridanie používateľa</button>    
        <div id="create-form" style="display: none;">
            <br>
            <form method="post" action="{{ route('user.store') }}">
                @csrf
                <label for="meno">Meno:</label>
                <input type="text" name="meno" required>

                <label for="priezvisko">Priezvisko:</label>
                <input type="text" name="priezvisko" required>

                <label for="tel_cislo">Telefonné číslo:</label>
                <input type="text" name="tel_cislo" required>

                <label for="email">Email:</label>
                <input type="text" name="email" required>
                
                <label for="password">Heslo:</label>
                <input type="text" name="password" required>

                <label for="rola_pouzivatela_id">Vybrať rolu:</label>
                <select name="rola_pouzivatela_id">                            
                    @foreach($user_roles as $user_roles)
                        <option value="{{ $user_roles->id }}">
                            {{ $user_roles->rola }}           
                        </option>                                       
                     @endforeach
                </select>

                <button type="submit">Vytvoriť</button>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $("#create-form").hide();

            $("#toggle-form").click(function() {
                $("#create-form").toggle();
            });
        });
    </script>

</body>
</html>
