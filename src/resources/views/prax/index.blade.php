<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-8Bl9kEdA9lCm0OSNYAnleCqZIDbhUVJ-0AC1rADdHvy2QIwMz8TnMa2AI5O3ukbzNhC2/GfQlZGpzQP9LrYGGg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" href="{{ asset('images/logo_2.png') }}" type="image/png">
    <title>Praxe</title>
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
<body>

    <nav class="navbar">
        <a href="{{ route('dashboard') }}">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="nav-logo">
        </a>
        <i class="fa-solid fa-bars menu-icon" style="color: #000205;"></i>
        <ul class="nav-links">
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
        <h1>Prax</h1>

        @if(session('success'))
            <div class="alert alert-success" role="alert">
                <i class="fas fa-check-circle alert__icon"></i>  {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
        <div class="alert alert-danger" role="alert">
            <i class="fas fa-times-circle alert__icon"></i>  {{ session('error') }}
        </div>
    @endif

        <ul>
            @foreach($praxe as $prax)
                <li>
                    {{ $prax->id }} - Popis praxe: {{ $prax->popis_praxe }} |Študent: {{ $prax->student->meno }} {{ $prax->student->priezvisko }}  | {{ $prax->datum_zaciatku }} to {{ $prax->datum_konca }} | firma: {{ $prax->contract->company->nazov_firmy }}
                    <form method="get" action="{{ route('prax.show', $prax->id) }}" style="display: inline;">
                        @csrf
                        <button type="submit">Zobraziť</button>
                    </form>
                    <form method="get" action="{{ route('prax.edit', $prax->id) }}" style="display: inline;">
                        @csrf
                        <button type="submit">Upraviť</button>
                    </form>
                    <form method="post" action="{{ route('prax.destroy', $prax->id) }}" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Vymazať</button>
                    </form>
                </li>
            @endforeach
        </ul>

        <button id="toggle-form">Pridanie praxe</button>
        
        <div id="create-form">
            <br>
            <form method="post" action="{{ route('prax.store') }}">
                @csrf
                <label for="popis_praxe">Popis praxe:</label>
                <input type="text" name="popis_praxe" required>

                <label for="datum_zaciatku">Dátum začiatku:</label>
                <input type="date" name="datum_zaciatku" required>

                <label for="datum_konca">Dátum konca:</label>
                <input type="date" name="datum_konca" required>

                <label for="aktualny_stav">Aktuálny stav:</label>
                <input type="text" name="aktualny_stav">
                @csrf
            <label for="student_id">Vybrať študenta:</label>
            <select name="student_id">
                @foreach($users as $user)
                    @if($user->rola_pouzivatela_id == 2)
                    <option value="{{ $user->id }}">
                        ID: {{ $user->id }} - {{ $user->meno }} {{ $user->priezvisko }}
                    </option>
                    @endif
                @endforeach
            </select>
            @csrf
                <label for="veduci_pracoviska_id">Vybrať vedúceho pracoviska:</label>
            <select name="veduci_pracoviska_id">
                @foreach($users as $user)
                    @if($user->rola_pouzivatela_id == 4)
                        <option value="{{ $user->id }}">
                            ID: {{ $user->id }} - {{ $user->meno }} {{ $user->priezvisko }}
                        </option>
                    @endif
                @endforeach
            </select>
            @csrf
                <label for="pracovnik_fpvai_id">Vybrať pracovníka FPVaI:</label>
            <select name="pracovnik_fpvai_id">
                @foreach($users as $user)
                    @if($user->rola_pouzivatela_id == 3)
                        <option value="{{ $user->id }}">
                            ID: {{ $user->id }} - {{ $user->meno }} {{ $user->priezvisko }}
                        </option>
                    @endif
                @endforeach
            </select>
            @csrf
                <label for="kontaktna_osoba_id">Vybrať kontaktú osobu firmy:</label>
            <select name="kontaktna_osoba_id">
                @foreach($users as $user)
                    @if($user->rola_pouzivatela_id == 5)
                        <option value="{{ $user->id }}">
                            ID: {{ $user->id }} - {{ $user->meno }} {{ $user->priezvisko }}
                        </option>
                    @endif
                @endforeach
            </select>
            @csrf
                <label for="dokumenty id">Document:</label>
            <select name="dokumenty id">
                @foreach($documents as $document)
                    <option value="{{ $document->id }}">
                        ID: {{ $document->id }} - {{ $document->typ_dokumentu }} | {{ $document->dokument }}
                    </option>
                @endforeach
            </select>
            @csrf
                <label for="predmety id">Predmet:</label>
            <select name="predmety id">
                @foreach($schoolSubjects as $subject)
                    <option value="{{ $subject->id }}">
                        ID: {{ $subject->id }} - {{ $subject->nazov }} 
                    </option>
                @endforeach
            </select>
            @csrf
                <label for="zmluva id">Zmluva:</label>
            <select name="zmluva id">
                @foreach($contracts as $contract)
                    <option value="{{ $contract->id }}">
                        ID: {{ $contract->id }} {{ $contract->zmluva }}
                    </option>
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
