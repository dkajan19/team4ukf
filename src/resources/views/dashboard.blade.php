<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-8Bl9kEdA9lCm0OSNYAnleCqZIDbhUVJ-0AC1rADdHvy2QIwMz8TnMa2AI5O3ukbzNhC2/GfQlZGpzQP9LrYGGg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://kit.fontawesome.com/361bfee177.js" crossorigin="anonymous"></script>
    <link rel="icon" href="{{ asset('images/logo_2.png') }}" type="image/png">
    <title>Domovská stránka</title>
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
                <li><a href="{{ route('student.program_and_subject') }}">Predmet</a></li>
                <li><a href="{{ route('student.internship_details') }}">Prax</a></li>
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

    <div class="container" id="container">
        @if($role == 'admin')
            <h2>Vitajte v administrátorskom prostredí</h2>
            <p>Ako administrátor máte prístup k pokročilým možnostiam správy aplikácie. Tu môžete vykonávať rôzne administratívne úlohy, vrátane správy používateľov, definovania rolí, a sledovania študijných programov.</p>
            <p style="color: red;">Nezabudnite, že s veľkou mocou prichádza veľká zodpovednosť. Dávajte pozor na zmeny, ktoré robíte, aby ste udržali integritu a bezpečnosť aplikácie.</p>
        @endif
        @if($role == 'Študent')
            <h2>Vitajte v študentskom prostredí</h2>
            <p>Ako študent máte možnosť spravovať svoju študentskú prax priamo tu. Môžete sledovať a aktualizovať informácie o svojej praxi.</p>
            <p style="color: red;">Nezabudnite, že študentská praxa je dôležitou súčasťou vášho vzdelávania, a preto dávajte pozor na termíny a splnenie požiadaviek.</p>
            <p>Ak budete mať otázky alebo potrebujete ďalšie informácie, neváhajte sa obrátiť na svojich školiteľov alebo koordinátorov študentskej praxe. Želáme vám úspešnú a vzdelávajúcu skúsenosť počas vašej študentskej praxe!</p>
        @endif
    </div>

</body>
</html>
