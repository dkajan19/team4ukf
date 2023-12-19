<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-8Bl9kEdA9lCm0OSNYAnleCqZIDbhUVJ-0AC1rADdHvy2QIwMz8TnMa2AI5O3ukbzNhC2/GfQlZGpzQP9LrYGGg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" href="{{ asset('images/logo_2.png') }}" type="image/png">
    <title>Zobrazenie firmy</title>
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
    @if($role == 'Poverený pracovník pracoviska')
        <style>
            :root {
                --link-count: 6;
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
            @if($role == 'Poverený pracovník pracoviska')
                <li><a href="{{ route('worker.company') }}">Firma</a></li>
                <li><a href="{{ route('worker.internship_details') }}">Prax</a></li>
                <li><a href="{{ route('worker.student') }}">Študent</a></li>
                <li><a href="{{ route('worker.documents') }}">Dokumenty</a></li>
                <li><a href="{{ route('worker.report') }}">Výkaz</a></li>

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
        <h1>Upraviť používateľa</h1>
        @if(session('success'))
            <div class="alert alert-success" role="alert">
                <i class="fas fa-check-circle alert__icon"></i>  {{ session('success') }}
            </div>
        @endif

        <form method="post" action="{{ route('worker.student_update', $user->id) }}">
            @csrf
            @method('PUT')

            <label for="meno">Meno:</label>
            <input type="text" name="meno" value="{{ $user->meno }}" required>

            <label for="priezvisko">Priezvisko:</label>
            <input type="text" name="priezvisko" value="{{ $user->priezvisko }}" required>

            <label for="tel_cislo">Telefonné číslo:</label>
            <input type="text" name="tel_cislo" value="{{ $user->tel_cislo}}" required>

            <label for="email">Email:</label>
            <input type="text" name="email" value="{{ $user->email }}" required>

            <button type="submit">Aktualizovať</button>
            
        </form>
        <a href="{{ route('worker.student') }}">Naspäť na študentov</a>   
    </div>




</body>
</html>
