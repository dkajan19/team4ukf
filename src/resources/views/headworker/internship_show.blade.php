<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-8Bl9kEdA9lCm0OSNYAnleCqZIDbhUVJ-0AC1rADdHvy2QIwMz8TnMa2AI5O3ukbzNhC2/GfQlZGpzQP9LrYGGg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" href="{{ asset('images/logo_2.png') }}" type="image/png">
    <title>Zobrazenie študijného programu</title>
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
    <style>
        :root {
            --link-count: 4;
        }
    </style>
</head>
<body>

    <nav class="navbar">
        <a href="{{ route('dashboard') }}">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="nav-logo">
        </a>
        <i class="fa-solid fa-bars menu-icon" style="color: #000205;"></i>
        <ul class="nav-links">
            <li><a href="{{ route('dashboard') }}">Domov</a></li>
            <li><a href="{{ route('headworker.internship_details') }}">Prax</a></li>
            <li><a href="{{ route('headworker.company') }}">Firma</a></li>
            <li><a href="{{ route('headworker.report') }}">Výkaz</a></li>
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
        <h1>Zobrazenie praxe</h1>

        <p><strong>Popis praxe:</strong> {{ $internship->popis_praxe }}</p>
        <p><strong>Dátum začiatku:</strong> {{ \Carbon\Carbon::parse($internship->datum_zaciatku)->format('d.m.Y') }}</p>
        <p><strong>Dátum konca:</strong> {{ \Carbon\Carbon::parse($internship->datum_konca)->format('d.m.Y') }}</p>
        <p><strong>Aktuálny stav:</strong> {{ $internship->aktualny_stav }}</p>
        <p><strong>Firma:</strong> {{ $internship->contract->company->nazov_firmy }}</p>
        <p><strong>Zmluva:</strong> {{ $internship->contract->zmluva }}</p>
        <p><strong>Dokumenty:</strong> {{ $internship->documents->typ_dokumentu }}</p>
        <p><strong>Predmet pokrývajúci prax:</strong> {{ $internship->schoolSubject->nazov }}</p>
        <p><strong>Študent:</strong> {{ $internship->student->meno }} {{ $internship->student->priezvisko }}</p>
        <p><strong>Poverený pracovník:</strong> {{ $internship->worker->meno }} {{ $internship->worker->priezvisko }}</p>
        <p><strong>Vedúci pracoviska:</strong> {{ $internship->headworker->meno }} {{ $internship->headworker->priezvisko }}</p>
        <p><strong>Kontaktná osoba:</strong> {{ $internship->contact->meno }} {{ $internship->contact->priezvisko }}</p>


        <a href="{{ route('headworker.internship_details') }}">Naspäť na Prax</a>
    </div>

</body>
</html>
