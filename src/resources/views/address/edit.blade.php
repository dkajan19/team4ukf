<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <title>Upraviť adresu</title>
</head>
<body>

    <div class="container">
        <h1>Upraviť adresu</h1>
        <hr><br>
        @if(session('success'))
            <div style="color: green;">
                {{ session('success') }}
            </div>
        @endif

        <form method="post" action="{{ route('address.update', $address->id) }}">
            @csrf
            @method('PUT')

            <label for="firma_id">Vybrať firmu:</label>
            <select name="firma_id">
                @foreach($companies as $company)
                    <option value="{{ $company->id }}" {{ $company->id == $address->firma_id ? 'selected' : '' }}>
                        {{ $company->nazov_firmy }}
                    </option>
                @endforeach
            </select>

            <label for="mesto">Mesto:</label>
            <input type="text" name="mesto" value="{{ $address->mesto }}" required>

            <label for="PSČ">PSČ:</label>
            <input type="text" name="PSČ" value="{{ $address->PSČ }}" required>

            <label for="ulica">Ulica:</label>
            <input type="text" name="ulica" value="{{ $address->ulica}}" required>

            <label for="č_domu">Číslo domu:</label>
            <input type="text" name="č_domu" value="{{ $address->č_domu }}" required>

            <button type="submit">Aktualizovať</button>
        </form>

        <a href="{{ route('address.index') }}">Naspäť na Adresy</a>
    </div>

</body>
</html>
