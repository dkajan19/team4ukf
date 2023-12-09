<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-8Bl9kEdA9lCm0OSNYAnleCqZIDbhUVJ-0AC1rADdHvy2QIwMz8TnMa2AI5O3ukbzNhC2/GfQlZGpzQP9LrYGGg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" href="{{ asset('images/logo_2.png') }}" type="image/png">
    <title>Adresy</title>
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
</head>
<body>

    <nav class="navbar">
        <a href="{{ route('dashboard') }}">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="nav-logo">
        </a>
        <i class="fa-solid fa-bars menu-icon" style="color: #000205;"></i>
        <ul class="nav-links">
            @if($role == 'admin')
                <li><a href="{{ route('dashboard') }}">Domov</a></li>
                <li><a href="{{ route('user_role.index') }}">Role používateľov</a></li>
                <li><a href="{{ route('study_program.index') }}">Študijné programy</a></li>
                <li><a href="{{ route('contract.index') }}">Zmluvy</a></li>
                <li><a href="{{ route('documents.index') }}">Dokumenty</a></li>
                <li><a href="{{ route('user.index') }}">Používatelia</a></li>
                <li><a href="{{ route('address.index') }}">Adresy</a></li>
                <li><a href="{{ route('company.index') }}">Firmy</a></li>
                <li><a href="{{ route('school_subject.index') }}">Predmety</a></li>
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
        <h1>Adresy</h1>
        @if(session('success'))
            <div class="alert alert-success" role="alert">
                <i class="fas fa-check-circle alert__icon"></i>  {{ session('success') }}
            </div>
        @endif
    
        <ul>
            @foreach($addresses->sortBy(function($address) {
                return optional($address->companiess)->nazov_firmy;
            }) as $address)
            <br>
            <li>
                {{ $address->companiess->nazov_firmy }} - {{ $address->mesto }}
                
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
                    @foreach($companies as $companiess)
                        <option value="{{ $companiess->id }}">
                            {{ $companiess->nazov_firmy }}           
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
