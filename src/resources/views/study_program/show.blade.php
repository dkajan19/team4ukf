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
            --link-count: 10;
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
        <h1>Zobrazenie študijného programu</h1>

        <p><strong>Názov:</strong> {{ $studyProgram->nazov }}</p>
        <p><strong>Skratka:</strong> {{ $studyProgram->skratka }}</p>

        <a href="{{ route('study_program.index') }}">Naspäť na Študijné programy</a>
    </div>

</body>
</html>
