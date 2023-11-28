<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-8Bl9kEdA9lCm0OSNYAnleCqZIDbhUVJ-0AC1rADdHvy2QIwMz8TnMa2AI5O3ukbzNhC2/GfQlZGpzQP9LrYGGg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" href="{{ asset('images/logo_2.png') }}" type="image/png">
    <title>Používateľský profil</title>
</head>
<body>

    <nav class="navbar">
        <a href="{{ route('dashboard') }}">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="nav-logo">
        </a>
        <ul class="nav-links">
                <li><a href="{{ route('dashboard') }}">Domov</a></li>
            @if($role == 'admin')
                <li><a href="{{ route('user_role.index') }}">Role používateľov</a></li>
                <li><a href="{{ route('study_program.index') }}">Študijné programy</a></li>
                <li><a href="{{ route('contract.index') }}">Zmluvy</a></li>
            @endif
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

    <div class="container" id="container">

        <h1>Používateľský profil</h1>

        @if(session('success'))
            <div style="color: green;">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div style="color: red;">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <div>
            <p><strong>Meno:</strong> {{ Auth::user()->meno }}</p>
            <p><strong>Priezvisko:</strong> {{ Auth::user()->priezvisko }}</p>
            <p><strong>Telefónne číslo:</strong> {{ Auth::user()->tel_cislo }}</p>
            <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
        </div>

        <hr>

        <h2>Upraviť profil</h2>

        <form method="post" action="{{ route('profile.update') }}">
            @csrf
            <label for="meno">Meno:</label>
            <input type="text" name="meno" value="{{ Auth::user()->meno }}" required>

            <label for="priezvisko">Priezvisko:</label>
            <input type="text" name="priezvisko" value="{{ Auth::user()->priezvisko }}" required>

            <label for="tel_cislo">Tel. číslo:</label>
            <input type="text" name="tel_cislo" value="{{ Auth::user()->tel_cislo }}" required>

            <label for="email">Email:</label>
            <input type="email" name="email" value="{{ Auth::user()->email }}" required>

            <button type="submit">Aktualizovať profil</button>
        </form>

        <hr>

        <h2>Zmena hesla</h2>

        <form method="post" action="{{ route('profile.updatePassword') }}">
            @csrf
            <label for="old_password">Staré heslo:</label>
            <input type="password" name="old_password" required>

            <label for="new_password">Nové heslo:</label>
            <input type="password" name="new_password" required>

            <label for="new_password_confirmation">Potvrďte nové heslo:</label>
            <input type="password" name="new_password_confirmation" required>

            <button type="submit">Zmeniť heslo</button>
        </form>

        <a href="{{ route('dashboard') }}">Naspäť na domovskú obrazovku</a>

    </div>

</body>
</html>
