<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-8Bl9kEdA9lCm0OSNYAnleCqZIDbhUVJ-0AC1rADdHvy2QIwMz8TnMa2AI5O3ukbzNhC2/GfQlZGpzQP9LrYGGg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" href="{{ asset('images/logo_2.png') }}" type="image/png">
    <title>Feedbacky</title>
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
    <h1>Feedbacky</h1>
    @if(session('success'))
        <div class="alert alert-success" role="alert">
            <i class="fas fa-check-circle alert__icon"></i>  {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger " role="alert">
        <i class="fas fa-times-circle alert__icon"></i> {{ session('error') }}
    </div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger" role="alert">
            <i class="fas fa-times-circle alert__icon"></i> Chyba pri vytváraní praxe:
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <ul>
        @foreach($feedbacks ->sortBy(function($feedback) {
            return optional($feedback->internship)->popis_praxe;
        }) as $feedback)
        <br>
        <li>
            {{ $feedback->internship->id }} - {{ $feedback->internship->popis_praxe }} - {{ $feedback->feedback }}
            
            <form method="get" action="{{ route('feedback.show', $feedback->id) }}" style="display: inline;">
                @csrf
                <button type="submit">Zobraziť</button>
            </form>
            
            <form method="get" action="{{ route('feedback.edit', $feedback->id) }}" style="display: inline;">
                @csrf
                <button type="submit">Upraviť</button>
            </form>
            
            <form method="post" action="{{ route('feedback.destroy', $feedback->id) }}" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit">Vymazať</button>
            </form>
        </li>
        @endforeach
    </ul>

    <button id="toggle-form">Pridanie feedbacku</button>    
    <div id="create-form" style="display: none;">
        <br>
        <form method="post" action="{{ route('feedback.store') }}">
            @csrf
            <label for="prax_id">Vybrať prax:</label>
            <select name="prax_id">
                @foreach($praxes as $prax)
                    <option value="{{ $prax->id }}">
                         {{ $prax->id }} - {{ $prax->popis_praxe }}
                    </option>
                @endforeach
            </select>

            <label for="feedback">Feedback:</label>
            <input type="text" name="feedback" required>

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
