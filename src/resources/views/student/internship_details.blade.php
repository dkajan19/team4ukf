<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-8Bl9kEdA9lCm0OSNYAnleCqZIDbhUVJ-0AC1rADdHvy2QIwMz8TnMa2AI5O3ukbzNhC2/GfQlZGpzQP9LrYGGg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" href="{{ asset('images/logo_2.png') }}" type="image/png">
    <title>Prax</title>
</head>

<body>

<nav class="navbar">
        <a href="{{ route('dashboard') }}">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="nav-logo">
        </a>
        <ul class="nav-links">
            <li><a href="{{ route('dashboard') }}">Domov</a></li>
            @if($role == 'admin')
                <li><a href="{{ route('user_role.index') }}">Role používateľov</a></li>
                <li><a href="{{ route('study_program.index') }}">Študijné programy</a></li>
                <li><a href="{{ route('contract.index') }}">Zmluvy</a></li>
                <li><a href="{{ route('documents.index') }}">Dokumenty</a></li>
                <li><a href="{{ route('user.index') }}">Používatelia</a></li>
                <li><a href="{{ route('address.index') }}">Adresy</a></li>
            @endif
            @if($role == 'Študent')
                <li><a href="{{ route('student.program_and_subject') }}">Predmet</a></li>
                <li><a href="{{ route('student.internship_details') }}">Prax</a></li>
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
                <div style="color: red;">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                        <br>
                    @endforeach
                </div>
            @endif

            @if(session('success'))
                <div style="color: green;">
                    {{ session('success') }}
                    <br>
                    <br>
                </div>
            @endif

        <button id="addCustomInternship" onclick="toggleCustomInternshipForm()">Pridať vlastnú prax</button>

        <div id="customInternshipForm" style="display: none;">
            <br>
            @php
                $canAddPrax = true;
                foreach ($student->prax as $prax) {
                    if ($prax->aktualny_stav === 'vytvorená') {
                        $canAddPrax = false;
                        break;
                    }
                }
            @endphp

            @if ($canAddPrax)
                <form method="POST" action="{{ route('student.add_custom_internship') }}">
                    @csrf
                    <label for="company_id_add">Vyberte firmu:</label>
                    <select name="company_id_add" style="width: 100%;">
                        @foreach ($companies_all as $company)
                            <option value="{{ $company->id }}">{{ $company->nazov_firmy }}</option>
                        @endforeach
                    </select>
                    <label for="description_add">Popis:</label>
                    <textarea name="description_add" style="width: 99%; height: 15em;"></textarea>
                    <br>
                    <br>
                    <button type="submit">Pridať vlastnú prax</button>
                </form>
            @else
                <p style="color:red;">Máte už vytvorenú prax so stavom "vytvorená", nemôžete pridať ďalšiu.</p>
            @endif
        </div>


        <h2>Zobraziť detaily o praxi</h2>
        <select id="internshipSelect" onchange="displayInternshipDetails()">
            <option value="" disabled selected>Vyberte ID praxe</option>
            @foreach ($praxes as $prax)
                <option value="{{ $prax->id }}">{{ $prax->id }}</option>
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
                var subjectHtml = (selectedPrax.school_subject.nazov !== 'NULL')
                ? "<p><strong>Predmet pokrývajúci prax:</strong> " + selectedPrax.school_subject.nazov + "</p>"
                : "<p style='display:inline;'><strong>Predmet pokrývajúci prax:</strong></p><p style='color:red;display:inline;'> Je potrebné vybrať  <a href='" + '{{ route("student.program_and_subject") }}' + "'>TU</a></p>";                var detailsHtml = "<h2>Detaily praxe</h2>" +
                    "<p><strong>Aktuálny stav:</strong> " + selectedPrax.aktualny_stav + "</p>" +
                    "<p><strong>Číslo zmluvy:</strong> " + selectedPrax.contract.zmluva + "</p>" +
                    "<p><strong>Dokumenty:</strong> " + selectedPrax.documents.id + "</p>" +
                    subjectHtml +
                    "<p><strong>Popis:</strong> " + selectedPrax.popis_praxe + "</p>" +
                    "<p><strong>Vedúci pracoviska:</strong> " + selectedPrax.head.meno + " " + selectedPrax.head.priezvisko + "</p>" +
                    "<p><strong>Poverený pracovník pracoviska:</strong> " + selectedPrax.worker.meno + " " + selectedPrax.worker.priezvisko + "</p>";

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
