<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <title>Upraviť študijný program</title>
</head>
<body>

    <h1>Upraviť študijný program</h1>

    @if(session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif

    <form method="post" action="{{ route('study_program.update', $studyProgram->id) }}">
        @csrf
        @method('PUT')

        <label for="nazov">Názov:</label>
        <input type="text" name="nazov" value="{{ $studyProgram->nazov }}" required>

        <label for="skratka">Skratka:</label>
        <input type="text" name="skratka" value="{{ $studyProgram->skratka }}" required>

        <button type="submit">Aktualizovať</button>
    </form>

    <a href="{{ route('study_program.index') }}">Naspäť na hlavnú stránku</a>

</body>
</html>
