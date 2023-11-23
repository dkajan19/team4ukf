<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <title>Dashboard</title>
</head>
<body>

    <div class="container">
        <h1>Dashboard</h1>
        <p>Vítame ťa v tvojom dashboarde!</p>

        <form action="{{ route('logout') }}" method="post">
            @csrf
            <button type="submit">Odhlásiť sa</button>
        </form>
    </div>

</body>
</html>
