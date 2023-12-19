<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="icon" href="{{ asset('images/logo_2.png') }}" type="image/png">
    <script src="https://kit.fontawesome.com/361bfee177.js" crossorigin="anonymous"></script>
    <title>Resetovanie hesla</title>
</head>
<body>
    <div class="container">
        <center><img src="{{ asset('images/logo_2.png') }}" alt="Logo" style="width: 50px; height: 50px;"></center>
        <form method="POST" action="{{ route('password.update') }}" onsubmit="return validateForm()">
            @csrf

            @error('password')
                <div class="alert alert-danger" role="alert">
                    <i class="fas fa-minus-circle alert__icon"></i>  {{ $message }}
                </div>
            @enderror

            <div id="passwordMismatch" class="alert alert-danger" role="alert" style="display: none;">
                <i class="fas fa-minus-circle alert__icon"></i>  Heslá sa nezhodujú.
            </div>

            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ $email }}">

            <br>

            <label for="password">Nové heslo</label>
            <input type="password" name="password" id="password" required>

            <label for="password_confirmation">Potvrďte nové heslo</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required>

            <button type="submit">Resetovať heslo</button>
        </form>

        <a href="{{ route('login') }}">Naspäť na prihlasovanie</a>
    </div>

    <script>
        function validateForm() {
            var password = document.getElementById('password').value;
            var confirmPassword = document.getElementById('password_confirmation').value;

            if (password !== confirmPassword) {
                document.getElementById('passwordMismatch').style.display = 'block';
                return false;
            }

            return true;
        }
    </script>

</body>
</html>
