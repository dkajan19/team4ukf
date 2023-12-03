<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <title>Zobrazenie používateľa</title>
</head>
<body>

    <div class="container">
        <h1>Zobrazenie používateľa</h1>
        <hr>
        <p><strong>Meno:</strong> {{ $user->meno }}</p>
        <p><strong>Priezvisko:</strong> {{ $user->priezvisko }}</p>
        <p><strong>Telefonné čislo:</strong> {{ $user->tel_cislo }}</p>
        <p><strong>Email:</strong> {{ $user->email}}</p>
        <p><strong>Heslo:</strong> {{ $user->password }}</p>
        <p><strong>Rola:</strong> {{ $user->user_role->rola }}</p>

        <a href="{{ route('user.index') }}">Naspäť na Používateľa</a>
    </div>

</body>
</html>
