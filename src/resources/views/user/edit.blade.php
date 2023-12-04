<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-8Bl9kEdA9lCm0OSNYAnleCqZIDbhUVJ-0AC1rADdHvy2QIwMz8TnMa2AI5O3ukbzNhC2/GfQlZGpzQP9LrYGGg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" href="{{ asset('images/logo_2.png') }}" type="image/png">
    <title>Upraviť používateľa</title>
</head>
<body>

    <nav class="navbar">
        <a href="{{ route('dashboard') }}">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="nav-logo">
        </a>
        <ul class="nav-links">
            <li><a href="{{ route('dashboard') }}">Domov</a></li>
            <li><a href="{{ route('user_role.index') }}">Role používateľov</a></li>
            <li><a href="{{ route('study_program.index') }}">Študijné programy</a></li>
            <li><a href="{{ route('contract.index') }}">Zmluvy</a></li>
            <li><a href="{{ route('documents.index') }}">Dokumenty</a></li>
            <li><a href="{{ route('user.index') }}">Používatelia</a></li>
            <li><a href="{{ route('address.index') }}">Adresy</a></li>
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

            <label for="password">Heslo (Použite Bcrypt-Generator <a href="https://bcrypt-generator.com/" target="_blank">TU</a>)</label>
            <input type="text" name="password" value="{{ $user->password }}" required>
            
            <br>
            <label for="rola_pouzivatela_id">Vybrať rolu:</label>
            <select name="rola_pouzivatela_id">
                @foreach($user_roles as $user_roles)
                    <option value="{{ $user_roles->id }}" {{ $user_roles->id == $user->rola_pouzivatela_id ? 'selected' : '' }}>
                        {{ $user_roles->rola }}
                    </option>
                @endforeach
            </select>

            <button type="submit">Aktualizovať</button>
        </form>

        <a href="{{ route('user.index') }}">Naspäť na Používatelia</a>
    </div>

</body>
</html>
