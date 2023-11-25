<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-8Bl9kEdA9lCm0OSNYAnleCqZIDbhUVJ-0AC1rADdHvy2QIwMz8TnMa2AI5O3ukbzNhC2/GfQlZGpzQP9LrYGGg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Domovská stránka</title>
</head>
<body>

    <nav class="navbar">
        <a href="{{ route('dashboard') }}">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="nav-logo">
        </a>
        <ul class="nav-links">
            @if($role == 'admin')
                <li><a href="{{ route('dashboard') }}">Domov</a></li>
                <li><a href="{{ route('user_role.index') }}">Role používateľov</a></li>
                <li><a href="{{ route('study_program.index') }}">Študijné programy</a></li>
            @endif
        </ul>

        <div class="user-actions">
            <img src="{{ asset('images/user_icon.png') }}" alt="User Icon" class="user-icon">
            <div class="logout-button">
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button type="submit">Odhlásiť sa</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container" id="container">
        @if($role == 'admin')
            <h2>Vitajte v administrátorskom prostredí</h2>
            <p>Ako administrátor máte prístup k pokročilým možnostiam správy aplikácie. Tu môžete vykonávať rôzne administratívne úlohy, vrátane správy používateľov, definovania rolí, a sledovania študijných programov.</p>
            <p style="color: red;">Nezabudnite, že s veľkou mocou prichádza veľká zodpovednosť. Dávajte pozor na zmeny, ktoré robíte, aby ste udržali integritu a bezpečnosť aplikácie.</p>
        @endif
    </div>

</body>
</html>
