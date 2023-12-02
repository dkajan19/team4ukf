<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-8Bl9kEdA9lCm0OSNYAnleCqZIDbhUVJ-0AC1rADdHvy2QIwMz8TnMa2AI5O3ukbzNhC2/GfQlZGpzQP9LrYGGg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" href="{{ asset('images/logo_2.png') }}" type="image/png">
    <title>Dokumenty</title>
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
                <li><a href="{{ route('contract.index') }}">Zmluvy</a></li>
                <li><a href="{{ route('documents.index') }}">Dokumenty</a></li>
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
        <h1>Dokumenty</h1>

        @if(session('success'))
            <div style="color: green;">
                {{ session('success') }}
            </div>
        @endif

        <ul>
        @foreach($documents as $document)
        <br>
            <li>
                {{ $document->typ_dokumentu }}
                
                <form method="get" action="{{ route('documents.show', $document->id) }}" style="display: inline;">
                    @csrf
                    <button type="submit">Zobraziť</button>
                </form>
                
                <form method="get" action="{{ route('documents.edit', $document->id) }}" style="display: inline;">
                    @csrf
                    <button type="submit">Upraviť</button>
                </form>
                
                <form method="post" action="{{ route('documents.destroy', $document->id) }}" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Vymazať</button>
                </form>
            </li>
        @endforeach
        </ul>

        <button id="toggle-form">Pridanie dokumentov</button>
        <div id="create-form">
            <form method="post" action="{{ route('documents.store') }}" enctype="multipart/form-data">
                @csrf
                <br>
                <label for="typ_dokumentu">Typ dokumentu:</label>
                <input type="text" id="typ_dokumentu" name="typ_dokumentu" required>
                <label for="dokument">Vyberte súbor:</label>
                <input type="file" id="dokument" name="dokument" required>
            
                <button type="submit">Vytvoriť</button>
            </form>
        </div>

        <script>
            $(document).ready(function() {
                $("#create-form").hide();

                $("#toggle-form").click(function() {
                    $("#create-form").toggle();
                });
            });
        </script>
    </div>

</body>
</html>
