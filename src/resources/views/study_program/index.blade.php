<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <title>Študijné programy</title>
</head>
<body>

    <h1>Študijné programy</h1>

    @if(session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif

    <ul>
    @foreach($studyPrograms as $studyProgram)
        <li>
            {{ $studyProgram->nazov }} - {{ $studyProgram->skratka }}
            
            <form method="get" action="{{ route('study_program.show', $studyProgram->id) }}" style="display: inline;">
                @csrf
                <button type="submit">Zobraziť</button>
            </form>
            
            <form method="get" action="{{ route('study_program.edit', $studyProgram->id) }}" style="display: inline;">
                @csrf
                <button type="submit">Upraviť</button>
            </form>
            
            <form method="post" action="{{ route('study_program.destroy', $studyProgram->id) }}" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit">Vymazať</button>
            </form>
        </li>
    @endforeach
</ul>


    <button id="toggle-form">Pridanie študijného programu</button>

<div id="create-form">
    <form method="post" action="{{ route('study_program.store') }}">
        @csrf
        <label for="nazov">Názov:</label>
        <input type="text" name="nazov" required>

        <label for="skratka">Skratka:</label>
        <input type="text" name="skratka" required>

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
