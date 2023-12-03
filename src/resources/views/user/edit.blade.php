<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <title>Upraviť používateľa</title>
</head>
<body>

    <div class="container">
        <h1>Upraviť používateľa</h1>
        <hr><br>
        @if(session('success'))
            <div style="color: green;">
                {{ session('success') }}
            </div>
        @endif

        <form method="post" action="{{ route('user.update', $user->id) }}">
            @csrf
            @method('PUT')

            <label for="meno">Meno:</label>
            <input type="text" name="meno" value="{{ $user->meno }}" required>

            <label for="priezvisko">Priezvisko:</label>
            <input type="text" name="priezvisko" value="{{ $user->priezvisko }}" required>

            <label for="tel_cislo">Telefonné číslo:</label>
            <input type="text" name="tel_cislo" value="{{ $user->tel_cislo}}" required>

            <label for="email">Email:</label>
            <input type="text" name="email" value="{{ $user->email }}" required>

            <label for="password">Password:</label>
            <input type="text" name="password" value="{{ $user->password }}" required>

            <label for="rola_pouzivatela_id">Vybrať rolu:</label>
            <select name="rola_pouzivatela_id">
                @foreach($user_roles as $user_role)
                    <option value="{{ $user_role->id }}" {{ $user_role->id == $user->rola_pouzivatela_id ? 'selected' : '' }}>
                        {{ $user_role->rola }}
                    </option>
                @endforeach
            </select>

            <button type="submit">Aktualizovať</button>
        </form>

        <a href="{{ route('user.index') }}">Naspäť na Používateľa</a>
    </div>

</body>
</html>
