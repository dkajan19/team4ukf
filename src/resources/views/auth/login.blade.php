<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <title>Prihlásenie</title>
</head>
<body>

    <div class="container">
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
        </form>
    </div>

</body>
</html>
