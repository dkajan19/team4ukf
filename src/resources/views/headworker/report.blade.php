<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        integrity="sha512-8Bl9kEdA9lCm0OSNYAnleCqZIDbhUVJ-0AC1rADdHvy2QIwMz8TnMa2AI5O3ukbzNhC2/GfQlZGpzQP9LrYGGg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
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
    @if($role == 'Vedúci pracoviska')
        <style>
            :root {
                --link-count: 4;
            }
        </style>
    @endif
    <style>
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .table th {
            background-color: #f2f2f2;
        }

        .table tbody tr:hover {
            background-color: #f5f5f5;
        }

        canvas {
            display: block;
            max-width: 100%;
            margin-top: 20px;
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
            @if($role == 'Vedúci pracoviska')
                <li><a href="{{ route('headworker.internship_details') }}">Prax</a></li>
                <li><a href="{{ route('headworker.company') }}">Firma</a></li>
                <li><a href="{{ route('headworker.report') }}">Výkaz</a></li>
            @endif
        </ul>

        <div class="user-actions">
            <a href="{{ route('profile.index') }}"><img src="{{ asset('images/user_icon.png') }}" alt="User Icon"
                    class="user-icon"></a>
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
                    <i class="fas fa-minus-circle alert__icon"></i> {{ $error }}
                </div>
            @endforeach
        @endif

        @if(session('success'))
            <div class="alert alert-success" role="alert">
                <i class="fas fa-check-circle alert__icon"></i> {{ session('success') }}
            </div>
        @endif

        @if($praxe->count() == 0)
            <div class="alert alert-danger" role="alert">
                <i class="fas fa-minus-circle alert__icon"></i> Žiadne praxe na zobrazenie.
            </div>
        @else
            <h1>Výkaz</h1>

            <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>

            <button onclick="generovatPDF()">Generovať PDF</button>

            <script>
                function generovatPDF() {
                    var obsahPDF = document.getElementById('pdf');


                    html2pdf(obsahPDF, {
                        margin: 10,
                        filename: 'vykaz.pdf',
                        image: { type: 'jpeg', quality: 0.98 },
                        html2canvas: { scale: 2 },
                        jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' },
                    });
                }
            </script>

            <div id="pdf">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Aktuálny stav</th>
                            <th>Dátum začiatku</th>
                            <th>Dátum konca</th>
                            <th>Firma</th>
                            <th>Meno a priezvisko študenta</th>
                            <th>Meno a priezvisko povereného pracovníka</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($praxe as $prax)
                            <tr>
                                <td>{{ $prax->id }}</td>
                                <td>{{ $prax->aktualny_stav }}</td>
                                <td>{{ \Carbon\Carbon::parse($prax->datum_zaciatku)->format('d.m.Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($prax->datum_konca)->format('d.m.Y') }}</td>
                                <td>{{ $prax->contract->company->nazov_firmy }}</td>
                                <td>{{ $prax->student->meno }} {{ $prax->student->priezvisko }}</td>
                                <td>{{ $prax->worker->meno }} {{ $prax->worker->priezvisko }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @php
                $praxStavy = DB::table('prax')
                    ->select('aktualny_stav', DB::raw('COUNT(*) as count'))
                    ->groupBy('aktualny_stav')
                    ->get();

                $stavy = $praxStavy->pluck('aktualny_stav');
                $pocetPraxi = $praxStavy->pluck('count');

                $praxPovereni = \App\Models\Internship::join('pouzivatel', 'prax.pracovnik_fpvai_id', '=', 'pouzivatel.id')
                    ->select('pracovnik_fpvai_id', \DB::raw('COUNT(*) as count'))
                    ->groupBy('pracovnik_fpvai_id')
                    ->get();

                $povereniIds = $praxPovereni->pluck('pracovnik_fpvai_id');
                $pocetPraxiPovereni = $praxPovereni->pluck('count');
                $povereniNames = \App\Models\User::whereIn('id', $povereniIds)->get(['meno', 'priezvisko']);

                $praxFirmy = \App\Models\Internship::join('zmluva', 'prax.zmluva_id', '=', 'zmluva.id')
                    ->join('firma', 'zmluva.firma_id', '=', 'firma.id')
                    ->select('firma_id', \DB::raw('COUNT(*) as count'))
                    ->groupBy('firma_id')
                    ->get();

                $firmyIds = $praxFirmy->pluck('firma_id');
                $pocetPraxiFirmy = $praxFirmy->pluck('count');
                $firmyNames = \App\Models\Company::whereIn('id', $firmyIds)->get(['nazov_firmy']);
            @endphp

            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <canvas id="myChart" style="page-break-before: always;"></canvas>
            <canvas id="mySecondChart" style="page-break-before: always;"></canvas>
            <canvas id="myThirdChart" style="page-break-before: always;"></canvas>

            <script>
                function generateRandomColors(count) {
                    var colors = [];
                    for (var i = 0; i < count; i++) {
                        var color = '#' + Math.floor(Math.random() * 16777215).toString(16);
                        colors.push(color);
                    }
                    return colors;
                }
            </script>

            <script>
                var stavyColors = generateRandomColors(3);
                var ctx = document.getElementById('myChart').getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode($stavy) !!},
                        datasets: [{
                            label: 'Počet praxí podla aktuálneho stavu',
                            data: {!! json_encode($pocetPraxi) !!},
                            backgroundColor: stavyColors,
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            </script>

            <script>
                var povereniNames = {!! json_encode($povereniNames->pluck('priezvisko')) !!};
                var povereniColors = generateRandomColors(povereniNames.length);

                var ctx2 = document.getElementById('mySecondChart').getContext('2d');
                var mySecondChart = new Chart(ctx2, {
                    type: 'bar',
                    data: {
                        labels: povereniNames,
                        datasets: [{
                            label: 'Počet praxí podľa povereného pracovníka',
                            data: {!! json_encode($pocetPraxiPovereni) !!},
                            backgroundColor: povereniColors,
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            </script>
            <script>
                var firmyNames = {!! json_encode($firmyNames->pluck('nazov_firmy')) !!};
                var firmyColors = generateRandomColors(firmyNames.length);

                var ctx3 = document.getElementById('myThirdChart').getContext('2d');
                var myThirdChart = new Chart(ctx3, {
                    type: 'bar',
                    data: {
                        labels: firmyNames,
                        datasets: [{
                            label: 'Počet praxí podľa firmy',
                            data: {!! json_encode($pocetPraxiFirmy) !!},
                            backgroundColor: firmyColors,
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            </script>

</div>
        @endif
    </div>

</body>

</html>
