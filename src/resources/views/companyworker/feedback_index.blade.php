<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-8Bl9kEdA9lCm0OSNYAnleCqZIDbhUVJ-0AC1rADdHvy2QIwMz8TnMa2AI5O3ukbzNhC2/GfQlZGpzQP9LrYGGg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" href="{{ asset('images/logo_2.png') }}" type="image/png">
    <title>Spätná väzba</title>
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
    @if($role == 'Zástupca firmy alebo organizácie')
        <style>
            :root {
                --link-count: 1;
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
            @if($role == 'Zástupca firmy alebo organizácie')
            <li><a href="{{ route('companyworker.feedback_index') }}">Spätná väzba</a></li>

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
        <h1>Spätná väzba</h1>

        @if($errors->any())
        <div class="alert alert-danger" role="alert">
            <i class="fas fa-times-circle alert__icon"></i> Chyba pri vytváraní feedbacku:
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger " role="alert">
        <i class="fas fa-times-circle alert__icon"></i> {{ session('error') }}
    </div>
    @endif

            @if(session('success'))
                <div class="alert alert-success" role="alert">
                    <i class="fas fa-check-circle alert__icon"></i>  {{ session('success') }}
                </div>
            @endif

        <ul>
        @foreach($feedbacks as $feedback)
        <br>
            <li>
                ID praxe: {{ $feedback->internship->id }} | {{ Illuminate\Support\Str::limit($feedback->internship->popis_praxe, 20, '...') }} | Feedback: {{ Illuminate\Support\Str::limit($feedback->feedback, 30, '...') }} | {{ $feedback->internship->student->meno }} {{ $feedback->internship->student->priezvisko }}

                <form method="get" action="{{ route('companyworker.feedback_show', $feedback->id) }}" style="display: inline;">
                    @csrf
                    <button type="submit">Zobraziť</button>
                </form>
                <form method="get" action="{{ route('companyworker.feedback_edit', $feedback->id) }}" style="display: inline;">
                    @csrf
                    <button type="submit">Upraviť</button>
                </form>
                <form method="post" action="{{ route('companyworker.feedback_destroy', $feedback->id) }}" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Vymazať</button>
                </form>

            </li>
        @endforeach
        </ul>

        <button id="toggle-form">Pridanie feedbacku</button>    
    <div id="create-form" style="display: none;">
        <br>
        <form method="post" action="{{ route('companyworker.feedback_store') }}">
            @csrf
            <label for="prax_id">Vybrať prax:</label>
            <select name="prax_id">
                @foreach($praxes as $prax)
                    <option value="{{ $prax->id }}">
                         {{ $prax->id }} - {{ Illuminate\Support\Str::limit($prax->popis_praxe, 20, '...') }} - {{ $prax->student->meno }} {{ $prax->student->priezvisko }}
                    </option>
                @endforeach
            </select>

                <label for="feedback">Spätná väzba:</label>
            <textarea name="feedback" rows="25" cols="111" required>{{ old('feedback', $prax->feedback) }}</textarea>

            <button type="submit">Vytvoriť</button>
        </form>
    </div>
</div>
<script>
    $(document).ready(function() {
        $("#create-form, #address-fields").hide();
        $("#toggle-form").click(function() {
            $("#create-form, #address-fields").toggle();
        });
    });
</script>

</body>
</html>
