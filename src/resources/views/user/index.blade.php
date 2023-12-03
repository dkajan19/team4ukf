<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    
    <title>Používateľ</title>
</head>
<body>
    
    <div class="container">
        <h1>Používateľ</h1><hr>
        @if(session('success'))
            <div style="color: green;">
                {{ session('success') }}
            </div>
        @endif
    
        <ul>
            @php
            $currentRole = null;
            @endphp
            <br>
            @foreach($users->sortBy(function($user) {
                return optional($user->user_role)->rola;
                }) as $user)
            @if($currentRole != $user->user_role->rola)
            @if(!is_null($currentRole))
                </ul><br>
            @endif
            
            <h2>{{ $user->user_role->rola }}</h2>
            <ul>

            @php
                $currentRole = $user->user_role->rola;
            @endphp
            @endif
            <br>
            <li>
                {{ $user->priezvisko }} - {{ $user->meno }}
                
                <form method="get" action="{{ route('user.show', $user->id) }}" style="display: inline;">
                    @csrf
                    <button type="submit">Zobraziť</button>
                </form>
                
                <form method="get" action="{{ route('user.edit', $user->id) }}" style="display: inline;">
                    @csrf
                    <button type="submit">Upraviť</button>
                </form>
                
                <form method="post" action="{{ route('user.destroy', $user->id) }}" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Vymazať</button>
                </form>
            </li>
            @endforeach
        </ul>
        <br><br>
    
        <button id="toggle-form">Pridanie používateľa</button>    
        <div id="create-form" style="display: none;">
            <br>
            <form method="post" action="{{ route('user.store') }}">
                @csrf
                <label for="meno">Meno:</label>
                <input type="text" name="meno" required>

                <label for="priezvisko">Priezvisko:</label>
                <input type="text" name="priezvisko" required>

                <label for="tel_cislo">Telefonné číslo:</label>
                <input type="text" name="tel_cislo" required>

                <label for="email">Email:</label>
                <input type="text" name="email" required>
                
                <label for="password">Heslo:</label>
                <input type="text" name="password" required>

                <label for="rola_pouzivatela_id">Vybrať rolu:</label>
                <select name="rola_pouzivatela_id">                            
                    @foreach($user_roles as $user_role)
                        <option value="{{ $user_role->id }}">
                            {{ $user_role->rola }}           
                        </option>                                       
                     @endforeach
                </select>

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
