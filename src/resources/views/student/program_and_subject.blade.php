<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-8Bl9kEdA9lCm0OSNYAnleCqZIDbhUVJ-0AC1rADdHvy2QIwMz8TnMa2AI5O3ukbzNhC2/GfQlZGpzQP9LrYGGg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" href="{{ asset('images/logo_2.png') }}" type="image/png">
    <title>Výber predmetu</title>
</head>
<body>

    <nav class="navbar">
        <a href="{{ route('dashboard') }}">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="nav-logo">
        </a>
        <ul class="nav-links">
            <li><a href="{{ route('dashboard') }}">Domov</a></li>
            <li><a href="{{ route('contract.index') }}">Predmet</a></li>
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
        <h1>Výber predmetu</h1>

        @if(session('error'))
            <p style="color: red;">{{ session('error') }}</p>
        @endif

        @if(session('success'))
            <p style="color: green;">{{ session('success') }}</p>
        @endif

        @if($student)
            <p class>Meno študenta: {{ $student->meno }} {{ $student->priezvisko }}</p>
        @endif

        @if($student && $prax)
            @if($prax->schoolSubject->nazov)
                <p>Priradený predmet z praxe: {{ $prax->schoolSubject->nazov }}</p>
            @else
                <p>Študent nemá priradený žiadny predmet v rámci praxe.</p>
            @endif
        @endif

        <hr><br>

        <form action="{{ route('select-program') }}" method="post">
            @csrf
            <label for="studijny_program">Vyberte študijný program:</label>
            <select name="studijny_program" id="studijny_program">
                @foreach($studijneProgramy as $program)
                    <option value="{{ $program->id }}" @if($selectedProgram && $selectedProgram->id == $program->id) selected @endif>
                        {{ $program->nazov }}
                    </option>
                @endforeach
            </select>
            <button type="submit">Potvrdiť výber</button>
        </form>

        @if($selectedProgram && $selectedProgram->schoolSubjects->count() > 0)
            <h3 class="subject-heading">Prislúchajúce predmety k študijnému programu "{{ $selectedProgram->nazov }}"</h3>
            <form action="{{ route('assign-subject') }}" method="post">
                @csrf
                <select name="selected_subject" id="selected_subject">
                    @foreach($selectedProgram->schoolSubjects as $predmet)
                        <option value="{{ $predmet->id }}">{{ $predmet->nazov }}</option>
                    @endforeach
                </select>
                <button type="submit">Priradiť predmet</button>
            </form>
        @endif

    </div>

</body>
</html
