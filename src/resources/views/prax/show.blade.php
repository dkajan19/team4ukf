<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-8Bl9kEdA9lCm0OSNYAnleCqZIDbhUVJ-0AC1rADdHvy2QIwMz8TnMa2AI5O3ukbzNhC2/GfQlZGpzQP9LrYGGg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" href="{{ asset('images/logo_2.png') }}" type="image/png">
    <title>Zobrazenie praxe</title>
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
    <h1>Zobrazenie Praxe</h1>
    <hr>
    <h2> ID: {{ $prax->id }}</h2>
    <p><strong>Popis praxe:</strong> {{ $prax->popis_praxe }}</p>
    <p><strong>Dátum začiatku:</strong> {{ $prax->datum_zaciatku }}</p>
    <p><strong>Dátum konca:</strong> {{ $prax->datum_konca }}</p>
    <p><strong>Aktuálny stav:</strong> {{ $prax->aktualny_stav }}</p>
    <p><strong>Študent:</strong> {{ $prax->student->meno }} {{ $prax->student->priezvisko }}</p>
    <p><strong>Vedúci pracoviska:</strong> {{ $prax->headworker->meno }} {{ $prax->headworker->priezvisko }}</p>
    <p><strong>Pracovník FPVaI:</strong> {{ $prax->worker->meno }} {{ $prax->worker->priezvisko }}</p>
    <p><strong>Kontaktná osoba:</strong> {{ $prax->contact->meno }} {{ $prax->contact->priezvisko }}</p>
    <p><strong>Dokumenty:</strong> <a href="{{ route('documents.show', $prax->documents->id) }}" target="_blank">{{ $prax->documents->typ_dokumentu }}</a></p>
    <p><strong>Predmet:</strong> {{ $prax->schoolSubject->nazov }} - {{ $prax->schoolSubject->skratka }}</p>
    <p><strong>Zmluva:</strong> <a href="{{ route('contract.show', $prax->contract->id) }}" target="_blank">{{ $prax->contract->zmluva }}</a></p>



    <a href="{{ route('prax.index') }}">Naspäť na Praxe</a>
</div>

</body>
</html>
