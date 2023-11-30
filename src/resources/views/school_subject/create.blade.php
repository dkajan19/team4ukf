<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-8Bl9kEdA9lCm0OSNYAnleCqZIDbhUVJ-0AC1rADdHvy2QIwMz8TnMa2AI5O3ukbzNhC2/GfQlZGpzQP9LrYGGg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" href="{{ asset('images/logo_2.png') }}" type="image/png">
    <title>Domovská stránka</title>
</head>
<body>
<!-- resources/views/school_subject/create.blade.php -->

<br>
<form method="post" action="{{ route('school_subject.store') }}">
    @csrf
    <label for="nazov">Názov:</label>
    <input type="text" name="nazov" required>

    <label for="skratka">Skratka:</label>
    <input type="text" name="skratka" required>

    <label for="study_program_id">Študijný program:</label>
    <select name="study_program_id" required>
        @foreach($studyPrograms as $studyProgram)
            <option value="{{ $studyProgram->id }}">{{ $studyProgram->nazov }}</option>
        @endforeach
    </select>

    <button type="submit">Vytvoriť</button>
</form>


</body>
</html>
