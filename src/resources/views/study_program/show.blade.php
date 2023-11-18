<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <title>Zobrazenie študijného programu</title>
</head>
<body>

    <h1>Zobrazenie študijného programu</h1>

    <p><strong>Názov:</strong> {{ $studyProgram->nazov }}</p>
    <p><strong>Skratka:</strong> {{ $studyProgram->skratka }}</p>

    <a href="{{ route('study_program.index') }}">Naspäť na hlavnú stránku</a>

</body>
</html>
