<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-8Bl9kEdA9lCm0OSNYAnleCqZIDbhUVJ-0AC1rADdHvy2QIwMz8TnMa2AI5O3ukbzNhC2/GfQlZGpzQP9LrYGGg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" href="{{ asset('images/logo_2.png') }}" type="image/png">
    <title>Používateľský profil</title>
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
            --link-count: 8;
        }
    </style>
@endif
@if($role == 'Študent')
    <style>
        :root {
            --link-count: 6;
        }
    </style>
@endif
@if($role == 'Poverený pracovník pracoviska')
    <style>
        :root {
            --link-count: 2;
        }
    </style>
@endif
@if($role == 'Vedúci pracoviska')
    <style>
        :root {
            --link-count: 1;
        }
    </style>
@endif
@if($role == 'Zástupca firmy alebo organizácie')
    <style>
        :root {
            --link-count: 1;
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
            @if($role == 'admin')
                <li><a href="{{ route('user_role.index') }}">Role používateľov</a></li>
                <li><a href="{{ route('study_program.index') }}">Študijné programy</a></li>
                <li><a href="{{ route('contract.index') }}">Zmluvy</a></li>
                <li><a href="{{ route('documents.index') }}">Dokumenty</a></li>
                <li><a href="{{ route('user.index') }}">Používatelia</a></li>
                <li><a href="{{ route('address.index') }}">Adresy</a></li>
                <li><a href="{{ route('company.index') }}">Firmy</a></li>
                <li><a href="{{ route('school_subject.index') }}">Predmety</a></li>
            @endif
            @if($role == 'Študent')
                <li><a href="{{ route('student.internship_details') }}">Prax</a></li>
                <li><a href="{{ route('student.company') }}">Firma</a></li>
                <li><a href="{{ route('student.program_and_subject') }}">Predmet</a></li>
                <li><a href="{{ route('student.report') }}">Výkaz</a></li>
                <li><a href="{{ route('student.documents') }}">Dokumenty</a></li>
            @endif
            @if($role == 'Poverený pracovník pracoviska')
                <li><a href="{{ route('worker.company') }}">Firma</a></li>
                <li><a href="{{ route('worker.internship_details') }}">Prax</a></li>
                <li><a href="{{ route('worker.student') }}">Študent</a></li>
                <li><a href="{{ route('worker.documents') }}">Dokumenty</a></li>

            @endif
            @if($role == 'Vedúci pracoviska')

            @endif
            @if($role == 'Zástupca firmy alebo organizácie')

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

    <div class="container" id="container">


        <h2>Pridať študenta</h2>

        <form method="post" action="{{ route('student.store') }}">
            @csrf
            <label for="meno">Meno:</label>
            <input type="text" name="meno" required>

            <label for="priezvisko">Priezvisko:</label>
            <input type="text" name="priezvisko" required>

            <label for="tel_cislo">Tel. číslo:</label>
            <input type="text" name="tel_cislo" required>

            <label for="email">Email:</label>
            <input type="email" name="email"  required>

            <label for="password">Heslo:</label>
            <input type="text" name="password"  required>

            <button type="submit">Vytvoriť profil</button>
        </form>

        <hr>



        <a href="{{ route('dashboard') }}">Naspäť na domovskú obrazovku</a>

    </div>

</body>
</html>
