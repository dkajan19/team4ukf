<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-8Bl9kEdA9lCm0OSNYAnleCqZIDbhUVJ-0AC1rADdHvy2QIwMz8TnMa2AI5O3ukbzNhC2/GfQlZGpzQP9LrYGGg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" href="{{ asset('images/logo_2.png') }}" type="image/png">
    <title>Firmy</title>
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
@if($role == 'Poverený pracovník pracoviska')
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
            @if($role == 'Poverený pracovník pracoviska')
                <li><a href="{{ route('worker.company') }}">Firma</a></li>
                <li><a href="{{ route('worker.internship_details') }}">Prax</a></li>
                <li><a href="{{ route('worker.student') }}">Študent</a></li>
                <li><a href="{{ route('worker.documents') }}">Dokumenty</a></li>
                <li><a href="{{ route('worker.report') }}">Výkaz</a></li>


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
        <h1>Všetky dokumenty</h1>

            @if($errors->any())
                <div style="color: red;">
                    @foreach($errors->all() as $error)
                        <div class="alert alert-danger" role="alert">
                            <i class="fas fa-minus-circle alert__icon"></i>  {{ $error }}
                        </div>
                    @endforeach
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success" role="alert">
                    <i class="fas fa-check-circle alert__icon"></i>  {{ session('success') }}
                </div>
            @endif

            <ul>
    @foreach($documentss as $document)
        <br>
        <li>
            Dokumenty <strong>ID_{{ $document->id }}</strong> s číslom <strong>{{ $document->typ_dokumentu }}</strong>
            @if($latestInternship = $latestInternships[$document->id])
                patriace pod Prax s <strong>ID_{{ $latestInternship->id }}</strong>
            @endif

            <button onclick="toggleDocumentDetails({{ $document->id }})" class="zobrazit">Zobraziť</button>

            <button onclick="toggleDocumentUpdate({{ $document->id }})" class="upravit">Upraviť</button>

            <form method="post" action="{{ route('worker.documents_destroy', $document->id) }}" style="display: inline;" id="delete-form-{{ $document->id }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="vymazat">Vymazať</button>
            </form>

            <div id="document-details-{{ $document->id }}" style="display:none;">
                <br>
                <p><strong>Číslo dokumentu:</strong> {{ $document->typ_dokumentu }}</p>
                <p><strong>Dokument:</strong>
                @if($document->dokument != null && $document->dokument != "null" )
                    <a href="{{ route('worker.documents_download', ['id' => $document->id]) }}">Stiahnuť dokumenty</a>
                    </p>
                @else
                    <div class="alert alert-danger" role="alert">
                        <i class="fas fa-minus-circle alert__icon"></i>  Dokument nebol doposiaľ nahraný!
                    </div>
                    </p>
                @endif
            </div>

            <div id="update-form-{{ $document->id }}" style="display:none;">
                <br>
                <form method="post" action="{{ route('worker.documents_update',['id' => $document->id]) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <label for="dokument">Vyberte súbor:</label>
                    <input type="file" name="dokument">

                    {{-- Add a hidden input for the document ID --}}
                    <input type="hidden" name="document_id" value="{{ $document->id }}">
                    
                    {{-- Add the hidden method field for PUT request --}}
                    <input type="hidden" name="_method" value="PUT">

                    <button type="submit" class="upravit">Upraviť</button>
                </form>
            </div>


        </li>
    @endforeach
</ul>

<script>
    function toggleDocumentUpdate(documentId) {
        var customInternshipForm = document.getElementById("update-form-" + documentId);
        customInternshipForm.style.display = (customInternshipForm.style.display === "none") ? "block" : "none";
    }
    function toggleDocumentDetails(documentId) {
        var customInternshipForm = document.getElementById("document-details-" + documentId);
        customInternshipForm.style.display = (customInternshipForm.style.display === "none") ? "block" : "none";
    }
</script>




    </div>

</script>

</body>
</html>
