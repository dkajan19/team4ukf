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
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        .controls {
            margin-top: 10px;
        }

    </style>
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

@if($prax)        
        <div id="obsahPDF">
            <h2 style="text-align:center;">Výkaz o vykonanej odbornej praxi</h2>
            <h3><i>ŠTUDENT</i></h3>
            <p><strong>Meno a priezvisko: </strong>{{ $student->meno }} {{ $student->priezvisko }}</p>
            <p><strong>Študijný program: </strong>{{ $prax->schoolSubject->study_programs->nazov }}</p>
            <p><strong>Názov a sídlo školy: </strong>Univerzita Konštantína Filozofa v Nitre, Tr. A. Hlinku 1, 949 01 Nitra</p>
            <br>
            <h3><i>ORGANIZÁCIA</i></h3>
            <p><strong>Názov a sídlo organizácie/pracoviska praxe: </strong>{{ $prax->contract->company->nazov_firmy }}, {{ $prax->contract->company->addresses->first()->ulica }} {{ $prax->contract->company->addresses->first()->č_domu }}, {{ $prax->contract->company->addresses->first()->mesto }} {{ $prax->contract->company->addresses->first()->PSČ }}</p>
            <p><strong>Meno a priezvisko zástupcu firmy: </strong>{{ $prax->contact->meno }} {{ $prax->contact->priezvisko }}</p>
            <br>
            <h3><i>OBDOBIE ABSOLVOVANIA ODBORNEJ PRAXE</i></h3>
            <p><strong>Dátum nástupu na prax: </strong>{{ $prax->datum_zaciatku }}</p>
            <p><strong>Dátum ukončenia praxe: </strong>{{ $prax->datum_konca }}</p>
            <br><br>
            <table id="praxTabulka">
                <thead>
                    <tr>
                        <th>Dátum</th>
                        <th>Popis činností</th>
                        <th>Počet hodín</th>
                        <th>Podpis zástupcu firmy</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="date" name="datum"></td>
                        <td><textarea style="max-width: 300px; max-height:100px;"></textarea></td>
                        <td><input type="time" name="cas" ></td>
                        <td contenteditable="false"></td>
                    </tr>
                </tbody>
            </table>
            <img src=" {{ asset('images/hodnotenie_studenta.png') }}" class="hodnotenie-studenta" style="max-width:800px; page-break-before: always; display: none;margin-left: auto;margin-right: auto;width: 100%;">
        </div>

        <div class="controls">
            <button class="add-row" onclick="pridatRiadok()">Pridať riadok +</button>
            <button class="remove-row" onclick="odstranitRiadok()">Odstrániť riadok -</button>
            <button onclick="generovatPDF()" style="float: right;">Generovať PDF</button>
        </div>
@else
    <div class="alert alert-danger" role="alert">
        <i class="fas fa-minus-circle alert__icon"></i>  Študent nemá žiadnu priradenú prax.
    </div>
@endif
    </div>
@if($prax) 
<script>
    
    function pridatRiadok() {
        var prazdnyRiadok = '<tr>' +
            '<td><input type="date" name="datum"></td>' +
            '<td><textarea style="max-width: 300px; max-height:100px;"></textarea></td>' +
            '<td><input type="time" name="cas"></td>' +
            '<td contenteditable="false"></td>' +
            '</tr>';

        var tabulka = document.getElementById('praxTabulka').getElementsByTagName('tbody')[0];
        var novyRiadok = tabulka.insertRow(tabulka.rows.length);
        novyRiadok.innerHTML = prazdnyRiadok;
    }

    function odstranitRiadok() {
        var pocetRiadkov = document.getElementById('praxTabulka').getElementsByTagName('tbody')[0].rows.length;

        if (pocetRiadkov > 1) {
            document.getElementById('praxTabulka').getElementsByTagName('tbody')[0].deleteRow(pocetRiadkov - 1);
        }
    }

    function generovatPDF() {
        document.querySelectorAll('input[name="datum"]').forEach(function (input) {
            input.style.border = 'none';
        });

        document.querySelectorAll('textarea').forEach(function (textarea) {
            textarea.style.border = 'none';
        });

        document.querySelectorAll('input[name="cas"]').forEach(function (input) {
            input.style.border = 'none';
        });

        document.getElementsByClassName('hodnotenie-studenta')[0].style.display = 'block';

        var obsahPDF = document.getElementById('obsahPDF');

        html2pdf(obsahPDF, {
            margin: 10,
            filename: 'vykaz_{{ $student->priezvisko }}.pdf',
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 2 },
            jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' },
        });

            setTimeout(function() {
            location.reload();
        }, 3000);
            
        
    }

</script>
@endif

</body>
</html>
