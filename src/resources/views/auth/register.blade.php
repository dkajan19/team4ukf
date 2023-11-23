<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <title>Registrácia</title>
</head>
<body>

    <div class="container">
        <form method="POST" action="{{ route('register') }}">
            @csrf

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
    </div>

</body>
</html>
