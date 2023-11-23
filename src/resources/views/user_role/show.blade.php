<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <title>Zobrazenie rolí používateľov</title>
</head>
<body>

    <h1>Zobrazenie rolí používateľov</h1>

    <p><strong>Názov:</strong> {{ $userRole->rola }}</p>

    <a href="{{ route('user_role.index') }}">Naspäť na hlavnú stránku</a>

</body>
</html>