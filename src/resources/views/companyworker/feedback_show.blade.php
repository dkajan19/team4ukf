<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-8Bl9kEdA9lCm0OSNYAnleCqZIDbhUVJ-0AC1rADdHvy2QIwMz8TnMa2AI5O3ukbzNhC2/GfQlZGpzQP9LrYGGg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" href="{{ asset('images/logo_2.png') }}" type="image/png">
    <title>Zobrazenie spätnej väzby</title>
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
          
            @if($role == 'Zástupca firmy alebo organizácie')
            <li><a href="{{ route('companyworker.feedback_index') }}">Spätná väzba</a></li>
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
        <h1>Zobrazenie feedbacku:</h1>
        <hr>
        <h2> ID praxe: {{ $feedback->internship->id }} </h2>
        <p><strong>Meno a prezvisko študenta: </strong>{{ $feedback->internship->student->meno }} {{ $feedback->internship->student->priezvisko }} </p>
        <p><strong>Názov firmy: </strong>{{ $feedback->internship->contract->company->nazov_firmy }}</p>
        <p><strong> Popis praxe: </strong> {{ $feedback->internship->popis_praxe }} </p>
        <p><strong>Feedback: </strong> {{ $feedback->feedback }}</p>
    
        <a href="{{ route('companyworker.feedback_index') }}">Naspäť na Feedbacky</a>
    </div>
    
    </body>
    </html>