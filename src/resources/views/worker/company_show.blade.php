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
    @if($role == 'Poverený pracovník pracoviska')
        <style>
            :root {
                --link-count: 2;
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
        <h1>{{ $company->nazov_firmy }}</h1>

        <p><strong>Názov firmy:</strong> {{ $company->nazov_firmy }}</p>
        <p><strong>IČO:</strong> {{ $company->IČO }}</p>
        <p><strong>Meno kontaktnej osoby:</strong> {{ $company->meno_kontaktnej_osoby }}</p>
        <p><strong>Priezvisko kontaktnej osoby:</strong> {{ $company->priezvisko_kontaktnej_osoby }}</p>
        <p><strong>Email:</strong> {{ $company->email }}</p>
        <p><strong>Telefónne číslo:</strong> {{ $company->tel_cislo }}</p>

        <select id="citySelect" onchange="displayCompanyAddresses()">
            <option value="" disabled selected>Vyberte mesto</option>
            @foreach($company->addresses as $address)
                <option value="{{ $address->mesto }}">{{ $address->mesto }}</option>
            @endforeach
        </select>

        <div id="companyAddressInfo" style="display: none;">
        </div>

        <a href="{{ route('worker.company_store', ['id' => $company->id]) }}">Naspäť na firmy</a>
    </div>

    <script>
        function displayCompanyAddresses() {
            const citySelect = document.getElementById('citySelect');
            const selectedCity = citySelect.value;
            const companyAddresses = @json($company->addresses);

            const selectedAddress = companyAddresses.find(address => address.mesto === selectedCity);

            if (selectedAddress) {
                const companyAddressInfo = document.getElementById('companyAddressInfo');
                companyAddressInfo.style.display = 'block';
                companyAddressInfo.innerHTML = `
                    <h2>${selectedAddress.mesto}</h2>
                    <p><strong>Mesto:</strong> ${selectedAddress.mesto}</p>
                    <p><strong>PSČ:</strong> ${selectedAddress.PSČ}</p>
                    <p><strong>Ulica:</strong> ${selectedAddress.ulica}</p>
                    <p><strong>Číslo domu:</strong> ${selectedAddress.č_domu}</p>
                `;
            } else {
                const companyAddressInfo = document.getElementById('companyAddressInfo');
                companyAddressInfo.style.display = 'none';
            }
        }
    </script>


</body>
</html>
