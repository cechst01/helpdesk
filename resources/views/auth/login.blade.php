<!doctype html>
<html lang="cs-CZ" prefix="og: http://ogp.me/ns#">
<head>
    <title>HELPDESK</title>

    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="" />
    <meta name="keywords" content="HTML,CSS,XML,JavaScript" />
    <meta name="author" content="" />

    <meta name="robots" content="noindex">

    <link rel="shortcut icon" href="{{asset('img/helpdesk-favico.ico')}}" type="image/x-icon">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" media="screen" href={{asset("css/style.css")}} />
    <link rel="stylesheet" media="screen" href={{asset("css/mystyle.css")}} />
    <link rel="stylesheet" media="screen" href="{{asset("css/jquery-ui.min.css")}}" type="text/css" />
    <link rel="stylesheet" media="screen" href="{{asset("css/devices.css")}}" />


    <!-- FONTS -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700" rel="stylesheet">
    <!-- FONTS -->

    <script type="text/javascript" src="{{asset("js/jquery-2.1.4.js")}}"></script>
    <script type="text/javascript" src="{{asset("js/jquery-ui.min.js")}}"></script>
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- Begin Cookie Consent plugin by Silktide - http://silktide.com/cookieconsent -->
    <script type="text/javascript">
        window.cookieconsent_options = {"message":"Teto web používá","dismiss":"rozumím!","learnMore":"cookies","link":"https://www.google.com/intl/cs_CZ/policies/technologies/cookies/","theme":"dark-bottom"};
    </script>
    {{--<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/1.0.9/cookieconsent.min.js"></script>--}}
    <!-- End Cookie Consent plugin -->

    <meta property="og:locale" content="cs_CZ">
    <meta property="og:type" content="">
    <meta property="og:title" content="">
    <meta property="og:description" content="">
    <meta property="og:url" content="">
    <meta property="og:site_name" content="">

</head>
<body class="login">
<header class="p30-bb">
    <div id="page-header" class="container flx aicjsb">
        <div class="header-left flx">
            <a class="logo" href="/"><img src="{{asset("img/logo.png")}}" alt="Logo"></a>
            <div class="contact flx">
                <img src="{{asset("img/userinfo.svg")}}" alt="Kontakt">
                <p>
                    <a href="tel:+420777112333">+420 777 112 333</a>
                    <a href="test@email.cz">test@email.cz</a>
                </p>
            </div>
        </div>
        <div class="header-right flx">

        </div>
    </div>
    <div class="container loginsection">
        <a class="logo" href="/"><img src="{{asset("img/logo.png")}}" alt="Logo"></a>
        <div class="helpdesk">helpdesk</div>
    </div>
</header>

<script type="text/javascript">
    $("body").addClaa("login");
</script>

<div class="prihlaseni">
    @include('../partial/flash')
    <div class="container flx">
        <div class="prihlaseni-content">
            <h1 class="title">PŘIHLÁŠENÍ</h1>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="row">
                    <div class="box">
                        <label for="email">Email:</label>
                        <input id="email" type="email" class="{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>
                        @if ($errors->has('email'))
                            <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="box">
                        <label for="password">Heslo:</label>
                        <input id="password" type="password" class="{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                        @if ($errors->has('password'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <button class="button" type="submit" name="button">přihlásit se</button>
            </form>
        </div>

    </div>
</div>

<footer>
    <div class="container flx aicjsb">
        <p><span>Firma s.r.o.</span> <br />Karla IV. 556/16, Olomouc,  779 00 <br /><strong>t:</strong> <a href="tel:+420777112333">+420 777 112 333</a>, <strong>m:</strong> <a href="test@email.cz">test@email.cz</a></p>
        <a class="logo" href="/"><img src={{asset("img/logo.png")}} alt="Logo"></a>
    </div>
</footer>

<div class="overlay"></div>
<a href="#" class="scrollToTop"></a>
</body>
</html>
