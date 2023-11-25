<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="icon" href="{{ asset('images/logo_2.png') }}" type="image/png">
    <title>Role používateľov</title>
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
        <h1>Role používateľov</h1>

        @if(session('success'))
            <div style="color: green;">
                {{ session('success') }}
            </div>
        @endif

        <ul>
        @foreach($userRole as $userRole)
        <br>
            <li>
                {{ $userRole->rola }}

                <form method="get" action="{{ route('user_role.show', $userRole->id) }}" style="display: inline;">
                    @csrf
                    <button type="submit">Zobraziť</button>
                </form>

                <form method="get" action="{{ route('user_role.edit', $userRole->id) }}" style="display: inline;">
                    @csrf
                    <button type="submit">Upraviť</button>
                </form>

                <form method="post" action="{{ route('user_role.destroy', $userRole->id) }}" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Vymazať</button>
                </form>
            </li>
        @endforeach
        </ul>

        <button id="toggle-form">Pridanie používateľskej role</button>

        <div id="create-form">
            <form method="post" action="{{ route('user_role.store') }}">
                @csrf
                <br>
                <label for="rola">Rola:</label>
                <input type="text" name="rola" required>

                <button type="submit">Vytvoriť</button>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $("#create-form").hide();
            $("#toggle-form").click(function() {
                $("#create-form").toggle();
            });
        });
    </script>

</body>
</html>
