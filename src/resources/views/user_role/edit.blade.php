<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <title>Upraviť role používateľov</title>
</head>
<body>

    <h1>Upraviť role používateľov</h1>

    @if(session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif

    <form method="post" action="{{ route('user_role.update', $userRole->id) }}">
        @csrf
        @method('PUT')

        <label for="nazov">Názov:</label>
        <input type="text" name="rola" value="{{ $userRole->rola }}" required>

        <button type="submit">Aktualizovať</button>
    </form>

    <a href="{{ route('user_role.index') }}">Naspäť na hlavnú stránku</a>

</body>
</html>