<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-8Bl9kEdA9lCm0OSNYAnleCqZIDbhUVJ-0AC1rADdHvy2QIwMz8TnMa2AI5O3ukbzNhC2/GfQlZGpzQP9LrYGGg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" href="{{ asset('images/logo_2.png') }}" type="image/png">
    <title>Predmety</title>
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
                <li><a href="{{ route('school_subject.index') }}">Predmety</a></li>
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
        <h1>Predmety</h1>

        @if(session('success'))
            <div style="color: green;">
                {{ session('success') }}
            </div>
        @endif

        <ul>
        @foreach($schoolSubjects as $schoolSubject)
        <br>
            <li>
                {{ $schoolSubject->nazov }} - {{ $schoolSubject->skratka }}

                <form method="get" action="{{ route('school_subject.show', $schoolSubject->id) }}" style="display: inline;">
                    @csrf
                    <button type="submit">Zobraziť</button>
                </form>

                <form method="get" action="{{ route('school_subject.edit', $schoolSubject->id) }}" style="display: inline;">
                    @csrf
                    <button type="submit">Upraviť</button>
                </form>

                <form method="post" action="{{ route('school_subject.destroy', $schoolSubject->id) }}" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Vymazať</button>
                </form>
            </li>
        @endforeach
        </ul>

        <button id="toggle-form">Pridanie predmetu</button>

        <div id="create-form">
            <br>
            <form method="post" action="{{ route('study_program.store') }}">
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
