<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <title>Dokumenty</title>
</head>
<body>

    <h1>Dokumenty</h1>

    @if(session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif

    <ul>
    @foreach($documents as $documents)
    <br>
        <li>
            {{ $documents->typ_dokumentu }}
            
            <form method="get" action="{{ route('documents.show', $documents->id) }}" style="display: inline;">
                @csrf
                <button type="submit">Zobraziť</button>
            </form>
            
            <form method="get" action="{{ route('documents.edit', $documents->id) }}" style="display: inline;">
                @csrf
                <button type="submit">Upraviť</button>
            </form>
            
            <form method="post" action="{{ route('documents.destroy', $documents->id) }}" style="display: inline;">
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

</body>
</html>
