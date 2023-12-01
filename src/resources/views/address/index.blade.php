<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    
    <title>Adresy</title>
</head>
<body>
    
    <div class="container">
        <h1>Adresy</h1>
        @if(session('success'))
            <div style="color: green;">
                {{ session('success') }}
            </div>
        @endif
    
        <ul>
            @foreach($addresses->sortBy(function($address) {
                return optional($address->company)->nazov_firmy;
            }) as $address)
            <br>
            <li>
                {{ $address->company->nazov_firmy }} - {{ $address->mesto }}
                
                <form method="get" action="{{ route('address.show', $address->id) }}" style="display: inline;">
                    @csrf
                    <button type="submit">Zobraziť</button>
                </form>
                
                <form method="get" action="{{ route('address.edit', $address->id) }}" style="display: inline;">
                    @csrf
                    <button type="submit">Upraviť</button>
                </form>
                
                <form method="post" action="{{ route('address.destroy', $address->id) }}" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Vymazať</button>
                </form>
            </li>
            @endforeach
        </ul>
        
    
        <button id="toggle-form">Pridanie adresy</button>    
        <div id="create-form" style="display: none;">
            <br>
            <form method="post" action="{{ route('address.store') }}">
                @csrf
                <label for="mesto">Mesto:</label>
                <input type="text" name="mesto" required>

                <label for="PSČ">PSČ:</label>
                <input type="text" name="PSČ" title="PSČ musí obsahovať 5 číslic" required pattern="[0-9]{5}">

                <label for="ulica">Ulica:</label>
                <input type="text" name="ulica" required>

                <label for="č_domu">Číslo domu:</label>
                <input type="text" name="č_domu" required>

                <label for="firma_id">Vybrať firmu:</label>
                <select name="firma_id">                            
                    @foreach($companies as $company)
                        <option value="{{ $company->id }}">
                            {{ $company->nazov_firmy }}           
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
