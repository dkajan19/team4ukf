<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="icon" href="{{ asset('images/logo_2.png') }}" type="image/png">
    <title>Prihlásenie</title>
</head>
<body>

    <div class="container">
        <center><img src="{{ asset('images/logo_2.png') }}" alt="Logo" style="width: 50px; height: 50px;"></center>
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- ERROR MESSAGE -->
            @if(session('error'))
                <p style="color: red;">{{ session('error') }}</p>
            @endif

            <label for="email">E-mailová adresa</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>

            <label for="password">Heslo</label>
            <input id="password" type="password" name="password" required>

            <button type="submit">Prihlásiť sa</button>

            <p>Nemáte účet? <a href="{{ route('register') }}">Zaregistrujte sa</a></p>
            <p>Zabudol si heslo? <a href="{{ route('password.request') }}">Resetuj ho</a></p>
        </form>
    </div>

</body>
</html>
