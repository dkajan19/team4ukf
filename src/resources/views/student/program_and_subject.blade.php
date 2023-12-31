<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-8Bl9kEdA9lCm0OSNYAnleCqZIDbhUVJ-0AC1rADdHvy2QIwMz8TnMa2AI5O3ukbzNhC2/GfQlZGpzQP9LrYGGg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" href="{{ asset('images/logo_2.png') }}" type="image/png">
    <title>Výber predmetu</title>
    <script src="https://kit.fontawesome.com/361bfee177.js" crossorigin="anonymous"></script>
    <script>
            document.addEventListener('DOMContentLoaded', function () {
                const menuIcon = document.querySelector('.menu-icon');
                const navLinks = document.querySelector('.nav-links');
                const container = document.querySelector('.container');

                menuIcon.addEventListener('click', function () {
                    navLinks.classList.toggle('show');
                    container.classList.toggle('show-menu');
                });
            });
    </script>
@if($role == 'admin')
    <style>
        :root {
            --link-count: 8;
        }
    </style>
@endif
@if($role == 'Študent')
    <style>
        :root {
            --link-count: 6;
        }
    </style>
@endif
</head>
<body>

    <nav class="navbar">
        <a href="{{ route('dashboard') }}">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="nav-logo">
        </a>
        <i class="fa-solid fa-bars menu-icon" style="color: #000205;"></i>
        <ul class="nav-links">
            <li><a href="{{ route('dashboard') }}">Domov</a></li>
            @if($role == 'admin')
                <li><a href="{{ route('user_role.index') }}">Role používateľov</a></li>
                <li><a href="{{ route('study_program.index') }}">Študijné programy</a></li>
                <li><a href="{{ route('contract.index') }}">Zmluvy</a></li>
                <li><a href="{{ route('documents.index') }}">Dokumenty</a></li>
                <li><a href="{{ route('user.index') }}">Používatelia</a></li>
                <li><a href="{{ route('address.index') }}">Adresy</a></li>
                <li><a href="{{ route('company.index') }}">Firmy</a></li>
                <li><a href="{{ route('school_subject.index') }}">Predmety</a></li>
            @endif
            @if($role == 'Študent')
                <li><a href="{{ route('student.internship_details') }}">Prax</a></li>
                <li><a href="{{ route('student.company') }}">Firma</a></li>
                <li><a href="{{ route('student.program_and_subject') }}">Predmet</a></li>
                <li><a href="{{ route('student.report') }}">Výkaz</a></li>
                <li><a href="{{ route('student.documents') }}">Dokumenty</a></li>
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
        
        @if($errors->any())
                @foreach($errors->all() as $error)
                    <div class="alert alert-danger" role="alert">
                        <i class="fas fa-minus-circle alert__icon"></i>  {{ $error }}
                    </div>
                @endforeach
            @endif

            @if(session('success'))
                <div class="alert alert-success" role="alert">
                    <i class="fas fa-check-circle alert__icon"></i>  {{ session('success') }}
                </div>
            @endif
@if($prax && $prax->aktualny_stav == 'vytvorená')
        <h1>Výber predmetu</h1>
        @if($student)
            <p class>Meno študenta: {{ $student->meno }} {{ $student->priezvisko }}</p>
        @endif

        @foreach($student->prax as $prax)
            @if($prax->aktualny_stav == 'vytvorená')
                @if($prax->schoolSubject)
                    @if($prax->schoolSubject->nazov == 'NULL')
                        <div class="alert alert-danger" role="alert">
                            <i class="fas fa-minus-circle alert__icon"></i>  Študent ešte nemá priradený predmet.
                        </div>
                    @else
                        <p>Priradený predmet z praxe: {{ $prax->schoolSubject->nazov }}</p>
                    @endif
                @else
                    <p>Student ešte nemá priradený predmet.</p>
                @endif
            @endif
        @endforeach

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
@else
    <div class="alert alert-danger" role="alert">
        <i class="fas fa-minus-circle alert__icon"></i>  Študent nemá žiadnu priradenú prax.
    </div>
@endif

    </div>

</body>
</html
