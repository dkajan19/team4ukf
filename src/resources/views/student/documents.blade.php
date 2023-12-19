<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-8Bl9kEdA9lCm0OSNYAnleCqZIDbhUVJ-0AC1rADdHvy2QIwMz8TnMa2AI5O3ukbzNhC2/GfQlZGpzQP9LrYGGg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" href="{{ asset('images/logo_2.png') }}" type="image/png">
    <title>Zobrazenie firmy</title>
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
@if($prax != null)
        <h1>Moje dokumenty</h1>

        @if(session('success'))
            <div class="alert alert-success" role="alert">
                <i class="fas fa-check-circle alert__icon"></i>  {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            @foreach($errors->all() as $error)
                <div class="alert alert-danger" role="alert">
                    <i class="fas fa-minus-circle alert__icon"></i>  {{ $error }}
                </div>
            @endforeach
        @endif

        <p><strong>Číslo zmluvy: </strong>{{ $prax->contract->zmluva }}</p>
        @if($prax->documents->dokument != "null")
            <p><a href="{{ route('student.documents_download', ['id' => $prax->documents->id]) }}">Stiahnuť dokumenty</a></p>
            

            <button onclick="toggleCustomInternshipForm()" class="upravit">Aktualizácia dokumentov</button>

            <form method="post" action="{{ route('student.documents_destroy', $prax->documents->id) }}" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="vymazat">Vymazať dokumenty</button>
            </form>

            <div id="update-form" style="display:none;">
                <br>
                <form method="post" action="{{ route('student.documents_update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                
                    <label for="dokument">Vyberte súbor:</label>
                    <input type="file" name="dokument">
                
                    <button type="submit">Aktualizovať</button>
                </form>
            </div>

        @else
            <div class="alert alert-warning" role="alert">
                <i class="fas fa-exclamation-triangle alert__icon"></i>  Nemáte žiadne dokumenty na stiahnutie, je potrebné ich nahrať nižšie.
            </div>

            <div id="update-form">
                <br>
                <h3>Nahrať dokumenty</h3>
                <form method="post" action="{{ route('student.documents_update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                
                    <label for="dokument">Vyberte súbor:</label>
                    <input type="file" name="dokument">
                
                    <button type="submit">Nahrať</button>
                </form>
            </div>
        @endif

@else
    <div class="alert alert-danger" role="alert">
        <i class="fas fa-minus-circle alert__icon"></i>  Študent nemá žiadnu priradenú prax.
    </div>
@endif
    </div>

    <script>
        function toggleCustomInternshipForm() {
            var customInternshipForm = document.getElementById("update-form");
            customInternshipForm.style.display = (customInternshipForm.style.display === "none") ? "block" : "none";
        }
    </script>

</body>
</html>
