<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-8Bl9kEdA9lCm0OSNYAnleCqZIDbhUVJ-0AC1rADdHvy2QIwMz8TnMa2AI5O3ukbzNhC2/GfQlZGpzQP9LrYGGg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" href="{{ asset('images/logo_2.png') }}" type="image/png">
    <title>Prax</title>
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


        <button id="addCustomInternship" onclick="toggleCustomInternshipForm()">Pridať prax</button>

        <div id="customInternshipForm" style="display: none;">
    <br>
    <form method="POST" action="{{ route('worker.add_custom_internship') }}">
        @csrf
        <label for="company_id_add">Vyberte firmu:</label>
        <select name="company_id_add" style="width: 100%;" required>
            <option value="" disabled selected>Vyberte firmu</option>
            @foreach ($companies_all as $company)
                <option value="{{ $company->id }}">{{ $company->nazov_firmy }}</option>
            @endforeach
        </select>
        <label for="student_id_add">Vyberte študenta:</label>
        <select name="student_id_add" style="width: 100%;" required>
            <option value="" disabled selected>Vyberte študenta</option>
            @foreach ($users as $student)
                <option value="{{ $student->id }}">{{ $student->meno }} {{ $student->priezvisko }}</option>
            @endforeach
        </select>
        <label for="description_add">Popis:</label>
        <textarea name="description_add" style="width: 99%; height: 15em;" required></textarea>
        <label for="datum_zaciatku_add">Dátum začiatku:</label>
        <input type="date" name="datum_zaciatku_add" required>
        <label for="datum_konca_add">Dátum konca:</label>
        <input type="date" name="datum_konca_add" required>
        <br>
        <br>
        <button type="submit">Pridať prax</button>
    </form>
</div>



            <h2>Zobraziť detaily o praxi</h2>
            <select id="internshipSelect" onchange="displayInternshipDetails()">
                <option value="" disabled selected>Vyberte ID praxe</option>
                @foreach ($praxes as $prax)
                    <option value="{{ $prax->id }}">{{ $prax->id }} - {{ $prax->popis_praxe}} - {{ $prax->contract->company->nazov_firmy}}</option>
                @endforeach
            </select>
            <div id="CompanyDetailsContainer"></div>

</div>
    <script>
        var praxes = @json($praxes);

        function displayInternshipDetails() {
            var internshipId = document.getElementById("internshipSelect").value;
            var CompanyDetailsContainer = document.getElementById("CompanyDetailsContainer");

            selectedPrax = praxes.find(prax => prax.id == internshipId);

            if (selectedPrax) {
                var rawDateStart = selectedPrax.datum_zaciatku;
                var formattedDateStart = new Date(rawDateStart).toLocaleDateString('sk-SK');
                var rawDateEnd = selectedPrax.datum_konca;
                var formattedDateEnd = new Date(rawDateEnd).toLocaleDateString('sk-SK');

                var subjectHtml = (selectedPrax.school_subject.nazov !== 'NULL')
                    ? "<p><strong>Predmet pokrývajúci prax:</strong> " + selectedPrax.school_subject.nazov + "</p>"
                    : "<p style='display:inline;'><strong>Predmet pokrývajúci prax:</strong></p><p style='color:red;display:inline;'> Doposiaľ nebol študentom vybraný!</p>";
                    
                    var detailsHtml = "<h2>Detaily praxe</h2>" +
                    "<div><p><strong>Aktuálny stav:</strong> <span id= aktualnyStav>" + selectedPrax.aktualny_stav + "</span></p>" +
                    "<button onclick= zmenitStav() >Zmeniť stav</button></div>" +

                    "<p><strong>Číslo zmluvy:</strong> " + selectedPrax.contract.zmluva + "</p>" +
                    "<p><strong>Dokumenty:</strong> " + selectedPrax.documents.id + "</p>" +
                    subjectHtml +
                    "<p><strong>Popis:</strong> " + selectedPrax.popis_praxe + "</p>" +
                    "<p><strong>Dátum začiatku:</strong> " + formattedDateStart + "</p>" +
                    "<p><strong>Dátum konca:</strong> " + formattedDateEnd + "</p>" +
                    "<p><strong>Vedúci pracoviska:</strong> " + selectedPrax.head.meno + " " + selectedPrax.head.priezvisko + "</p>" +
                    "<p><strong>Poverený pracovník pracoviska:</strong> " + selectedPrax.worker.meno + " " + selectedPrax.worker.priezvisko + "</p>" ;

                var currentStudentId = selectedPrax.student_id;

                var selectOptions = "<option value='' disabled>Vyberte študenta</option>";

                @foreach ($users as $user)
                var isSelected = currentStudentId === {{ $user->id }} ? ' selected' : '';
                selectOptions += "<option value='{{ $user->id }}'" + isSelected + ">{{ $user->meno }} {{ $user->priezvisko }}</option>";
                @endforeach

                    detailsHtml += "<div><p><strong>Priradený študent</strong> " +
                    "<select id='studentSelect' onchange='updateAssignedStudent()' style='width:auto;'>" +
                    selectOptions +
                    "</select></p></div>";



                detailsHtml += "<h2>Detaily firmy</h2>" +
                    "<p><strong>Názov firmy:</strong> " + selectedPrax.contract.company.nazov_firmy + "</p>" +
                    "<p><strong>Kontaktná osoba:</strong> " + selectedPrax.contract.company.meno_kontaktnej_osoby + " " + selectedPrax.contract.company.priezvisko_kontaktnej_osoby + "</p>" +
                    "<p><strong>Email:</strong> " + selectedPrax.contract.company.email + "</p>" +
                    "<p><strong>Telefónne číslo:</strong> " + selectedPrax.contract.company.tel_cislo + "</p>" +
                    "<h2>Adresa firmy</h2>" +
                    "<select id='addressesSelect' onchange='displayAddressDetails()'>" +
                    "<option value='' disabled selected>Vyberte mesto</option>";

                selectedPrax.contract.company.addresses.forEach(address => {
                    detailsHtml += "<option value='" + address.id + "'>" + address.mesto + "</option>";
                });

                detailsHtml += "</select><div id='addressDetailsContainer'></div>";

                CompanyDetailsContainer.innerHTML = detailsHtml;
            }
        }

        function zmenitStav() {
            var internshipId = selectedPrax.id; // Predpokladáme, že máme ID praxe
            var aktualnyStav = document.getElementById('aktualnyStav').innerHTML;
            var novyStav = aktualnyStav === 'prebiehajúca' ? 'archivovaná' : 'prebiehajúca';

            fetch('/update-internship-status', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // CSRF token je potrebný pre Laravel aplikácie
                },
                body: JSON.stringify({ internship_id: internshipId, new_status: novyStav })
            })
                .then(response => response.json())
                .then(data => {
                    console.log(data.message);
                    document.getElementById('aktualnyStav').innerHTML = novyStav;
                })
                .catch(error => console.error('Chyba: ', error));
        }

        function updateAssignedStudent() {
            var selectedStudentId = document.getElementById("studentSelect").value;
            var internshipId = selectedPrax.id; // ID praxe

            fetch('/update-internship-student', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ internship_id: internshipId, student_id: selectedStudentId })
            })
                .then(response => response.json())
                .then(data => {
                    console.log(data.message);
                    // Případně aktualizujte UI
                })
                .catch(error => console.error('Chyba: ', error));
        }



        function displayAddressDetails() {
            var addressId = document.getElementById("addressesSelect").value;
            var addressDetailsContainer = document.getElementById("addressDetailsContainer");
            addressDetailsContainer.innerHTML = "";

            var selectedAddress = selectedPrax.contract.company.addresses.find(address => address.id == addressId);

            if (selectedAddress) {
                var addressHtml =
                    "<p><strong>Mesto:</strong> " + selectedAddress.mesto + "</p>" +
                    "<p><strong>PSČ:</strong> " + selectedAddress.PSČ + "</p>" +
                    "<p><strong>Ulica a číslo domu:</strong> " + selectedAddress.ulica + " " + selectedAddress.č_domu + "</p>";

                addressDetailsContainer.innerHTML = addressHtml;
            }
        }

        function toggleCustomInternshipForm() {
            var customInternshipForm = document.getElementById("customInternshipForm");
            customInternshipForm.style.display = (customInternshipForm.style.display === "none") ? "block" : "none";
        }
    </script>
</body>

</html>
