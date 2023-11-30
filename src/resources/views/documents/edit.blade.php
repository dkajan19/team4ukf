<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <title>Upraviť dokumenty</title>
</head>
<body>

    <h1>Upraviť dokumenty</h1>

    @if(session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif

    <form method="post" action="{{ route('documents.update', $documents->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
    
        <label for="typ_dokumentu">Typ dokumentu:</label>
        <input type="text" name="typ_dokumentu" value="{{ $documents->typ_dokumentu }}" required>
    
        <label for="dokument">Vyberte súbor:</label>
        <input type="file" name="dokument">
    
        <button type="submit">Aktualizovať</button>
    </form>

    <a href="{{ route('documents.index') }}">Naspäť na hlavnú stránku</a>

</body>
</html>