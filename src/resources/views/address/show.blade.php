<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <title>Zobrazenie adresy</title>
</head>
<body>

    <div class="container">
        <h1>Zobrazenie adresy</h1>
        <hr>
        <h2>{{ $address->company->nazov_firmy }}</h2>

        <p><strong>Mesto:</strong> {{ $address->mesto }}</p>
        <p><strong>PSČ:</strong> {{ $address->PSČ }}</p>
        <p><strong>Ulica:</strong> {{ $address->ulica }}</p>
        <p><strong>Číslo domu:</strong> {{ $address->č_domu }}</p>

        <a href="{{ route('address.index') }}">Naspäť na Adresy</a>
    </div>

</body>
</html>
