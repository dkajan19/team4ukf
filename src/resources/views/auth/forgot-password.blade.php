<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="icon" href="{{ asset('images/logo_2.png') }}" type="image/png">
    <script src="https://kit.fontawesome.com/361bfee177.js" crossorigin="anonymous"></script>
    <title>Obnovenie hesla</title>
</head>
<body>

    <div class="container">
        <center><img src="{{ asset('images/logo_2.png') }}" alt="Logo" style="width: 50px; height: 50px;"></center>
        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            @error('email')
                <div class="alert alert-danger" role="alert">
                    <i class="fas fa-minus-circle alert__icon"></i>  {{ $message }}
                </div>
            @enderror

            <label for="email">Email</label>
            <input type="email" name="email" id="email" required>

            <button type="submit">Resetovať heslo</button>
        </form>

        <a href="{{ route('login') }}">Naspäť na prihlasovanie</a>
    </div>

</body>
</html>
