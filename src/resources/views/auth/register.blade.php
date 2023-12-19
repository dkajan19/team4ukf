<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="icon" href="{{ asset('images/logo_2.png') }}" type="image/png">
    <script src="https://kit.fontawesome.com/361bfee177.js" crossorigin="anonymous"></script>
    <title>Registrácia</title>
</head>
<body>

    <div class="container">
        <center><img src="{{ asset('images/logo_2.png') }}" alt="Logo" style="width: 50px; height: 50px;"></center>
        <form method="POST" action="{{ route('register') }}">
            @csrf

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

            <label for="meno">Meno</label>
            <input id="meno" type="text" name="meno" value="{{ old('meno') }}" required autofocus>

            <label for="priezvisko">Priezvisko</label>
            <input id="priezvisko" type="text" name="priezvisko" value="{{ old('priezvisko') }}" required>

            <label for="tel_cislo">Telefónne číslo</label>
            <input id="tel_cislo" type="text" name="tel_cislo" value="{{ old('tel_cislo') }}" required>

            <label for="email">E-mailová adresa</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required>

            <label for="password">Heslo</label>
            <input id="password" type="password" name="password" required>

            <label for="password_confirmation">Potvrdenie hesla</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required>

            <button type="submit">Registrovať sa</button>
        </form>

        <a href="{{ route('login') }}">Naspäť na prihlasovanie</a>

    </div>

</body>
</html>
