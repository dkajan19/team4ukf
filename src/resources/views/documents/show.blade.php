<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <title>Zobrazenie dokumentov</title>
</head>
<body>

    <h1>Zobrazenie dokumentov</h1>

    <p><strong>Typ dokumentu:</strong> {{ $documents->typ_dokumentu }}</p>
    <p><strong>Dokument:</strong> 
    <a href="{{ route('download', ['id' => $documents->id]) }}">Stiahnuť dokument</a>
    </p>
    
    <a href="{{ route('documents.index') }}">Naspäť na hlavnú stránku</a>

</body>
</html>

