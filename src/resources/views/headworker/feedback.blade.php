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
@if($role == 'Vedúci pracoviska')
    <style>
        :root {
            --link-count: 5;
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
            @if($role == 'Vedúci pracoviska')
                <li><a href="{{ route('headworker.internship_details') }}">Prax</a></li>
                <li><a href="{{ route('headworker.company') }}">Firma</a></li>
                <li><a href="{{ route('headworker.report') }}">Výkaz</a></li>
                <li><a href="{{ route('headworker.feedback') }}">Spätná väzba</a></li>
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

<style>
   
h2,h3{
	margin:0;
}

.status{
	width:8px;
	height:8px;
	border-radius:50%;
	display:inline-block;
	margin-right:7px;
}

.color{
    background-color:#FFD700;
    
}

#chat li{
	padding:10px 30px;
}
#chat h2,#chat h3{
	display:inline-block;
	font-size:13px;
	font-weight:normal;
}

#chat h3{
	color:#bbb;
}
#chat .entete{
	margin-bottom:5px;
}
#chat .message{
	padding:20px;
	color:#000;
	line-height:25px;
	max-width:90%;
	display:inline-block;
	text-align:left;
	border-radius:5px;
}
#chat .he .message{
	background-color:#FFD700;
}
#chat .triangle{
	width: 0;
	height: 0;
	border-style: solid;
	border-width: 0 10px 10px 10px;
}
#chat .he .triangle{
		border-color: transparent transparent #FFD700 transparent;
		margin-left:15px;
}
</style>

    <div class="container">
    @if($praxe !== null && count($praxe) !== 0)
        <h1>Spätná väzba</h1>

            @if($errors->any())
                <div style="color: red;">
                    @foreach($errors->all() as $error)
                        <div class="alert alert-danger" role="alert">
                            <i class="fas fa-minus-circle alert__icon"></i>  {{ $error }}
                        </div>
                    @endforeach
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success" role="alert">
                    <i class="fas fa-check-circle alert__icon"></i>  {{ session('success') }}
                </div>
            @endif

        <ul>
        @foreach($praxe as $prax)
        <br>
            <li>
                Prax <a href="{{ route('headworker.internship_show', $prax->id) }}""><b>ID_{{ $prax->id }}</b></a> študenta <b>{{ $prax->student->meno }} {{ $prax->student->priezvisko }}</b>, pod odborným vedením <b>{{ $prax->worker->meno }} {{ $prax->worker->priezvisko }}</b>,
                <br>obsahuje nasledujúce hodnotenie od zástupcu firmy <b>{{ $prax->contact->meno }} {{ $prax->contact->priezvisko }}</b>.<br><br>
                
                @if($prax->feedback != null)
                    <div id="chat" class="chat-{{ $prax->id }}">
                        <div class="he">
                            <div class="entete">
                                <span class="status color"></span>
                                <h2>{{ $prax->contact->meno }} {{ $prax->contact->priezvisko }}</h2>
                                @if($prax->feedback->updated_at != null)
                                    <h3>{{ $prax->feedback->updated_at->format('d. m. Y H:i:s') }}</h3>
                                @endif
                            </div>
                            <div class="triangle"></div>
                            <div class="message">
                            {{ $prax->feedback->feedback }}
                            </div>
                        </div>
                    </div>
                    <br>
                @else
                    <div class="alert alert-warning" role="alert">
                        <i class="fas fa-exclamation-triangle alert__icon"></i>  Spätná väzba nebola poskytnutá zástupcom firmy <b>{{ $prax->contact->meno }} {{ $prax->contact->priezvisko }}</b>.
                    </div>
                @endif
            </li>
        @endforeach
        </ul>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var chats = document.querySelectorAll('#chat .he');
            var colors = ['#FFD700', '#E5AA70', '#FA8072','#FFAC1C'];
            var colorIndex = 0;

            chats.forEach(function(chat) {
                var color = colors[colorIndex];
                colorIndex = (colorIndex + 1) % colors.length;

                chat.querySelector('.message').style.backgroundColor = color;
                chat.querySelector('.he .triangle').style.borderColor = 'transparent transparent ' + color + ' transparent';
                chat.querySelector('.color').style.backgroundColor = color;
            });
        });
    </script>
    @else
        <div class="alert alert-danger" role="alert">
            <i class="fas fa-minus-circle alert__icon"></i> Neexistuje prax na zobrazenie.
        </div>
    @endif
        
</div>
</body>
</html>
