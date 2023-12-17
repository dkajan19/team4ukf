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
</head>
<body>

    <nav class="navbar">
        <a href="{{ route('dashboard') }}">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="nav-logo">
        </a>
        <i class="fa-solid fa-bars menu-icon" style="color: #000205;"></i>
        <ul class="nav-links">
            @if($role == 'admin')
            <li><a href="{{ route('dashboard') }}">Domov</a></li>
            <li><a href="{{ route('user_role.index') }}">Role používateľov</a></li>
            <li><a href="{{ route('study_program.index') }}">Študijné programy</a></li>
            <li><a href="{{ route('contract.index') }}">Zmluvy</a></li>
            <li><a href="{{ route('documents.index') }}">Dokumenty</a></li>
            <li><a href="{{ route('user.index') }}">Používatelia</a></li>
            <li><a href="{{ route('address.index') }}">Adresy</a></li>
            <li><a href="{{ route('company.index') }}">Firmy</a></li>
            <li><a href="{{ route('school_subject.index') }}">Predmety</a></li>
            <li><a href="{{ route('feedback.index') }}">Feedback</a></li>
            <li><a href="{{ route('prax.index') }}">Prax</a></li>
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
            <div class="alert alert-success" role="alert" style="margin-bottom: 10px;">
                <i class="fas fa-check-circle alert__icon"></i>  {{ session('success') }}
            </div>
        @endif

        <label for="study_program_filter" style="margin-bottom: 10px;">Filtrovať podľa študijného programu:</label>
        <select id="study_program_filter" onchange="filterSubjects()" style="margin-bottom: 20px;">
            <option value="">Vyberte študijný program</option>
            @foreach($studyPrograms as $studyProgram)
                <option value="{{ $studyProgram->id }}">{{ $studyProgram->nazov }}</option>
            @endforeach
        </select>

        <ul id="filteredSubjects" style="list-style-type: disc; display:none; margin-left: 20px;">
            @foreach($schoolSubjects as $schoolSubject)
                <li class="subject" data-program="{{ $schoolSubject->studijny_program_id }}" style="margin-bottom: 10px;">
                    {{ $schoolSubject->nazov }} - {{ $schoolSubject->skratka }}
                    <form method="get" action="{{ route('school_subject.show', $schoolSubject->id) }}" style="display: inline;">
                        @csrf
                        <button type="submit">Zobraziť</button>
                    </form>
                    <form method="get" action="{{ route('school_subject.edit', $schoolSubject->id) }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="upravit">Upraviť</button>
                    </form>
                    <form method="post" action="{{ route('school_subject.destroy', $schoolSubject->id) }}" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="vymazat">Vymazať</button>
                    </form>
                </li>
            @endforeach
        </ul>

        <button id="toggle-form" style="margin-top: 20px;">Pridanie predmetu</button>

        <div id="create-form" style="margin-top: 10px;">
            <form method="post" action="{{ route('school_subject.store') }}">
                @csrf

                <label for="nazov">Názov:</label>
                <input type="text" name="nazov" required>

                <label for="skratka">Skratka:</label>
                <input type="text" name="skratka" required>

                <label for="studijny_program_id">Študijný program:</label>
                <select name="studijny_program_id" required>
                    @foreach($studyPrograms as $studyProgram)
                        <option value="{{ $studyProgram->id }}">{{ $studyProgram->nazov }}</option>
                    @endforeach
                </select>

                <button type="submit" style="margin-top: 10px;">Vytvoriť</button>
            </form>
        </div>
    </div>

    <script>
        function filterSubjects() {
            var selectedProgramId = document.getElementById('study_program_filter').value;
            var subjectsList = document.getElementById('filteredSubjects');

            if (selectedProgramId) {
                $("#filteredSubjects .subject").hide();
                $("#filteredSubjects .subject[data-program='" + selectedProgramId + "']").show();
                subjectsList.style.display = 'block';
            } else {
                subjectsList.style.display = 'none';
            }
        }

        $(document).ready(function() {
            $("#create-form").hide();
            $("#filteredSubjects").hide();
            $("#toggle-form").click(function() {
                $("#create-form").toggle();
            });
        });
    </script>

</body>
</html>
