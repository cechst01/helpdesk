<!DOCTYPE html>
<html lang="cs-CZ" prefix="og: http://ogp.me/ns#">
<head>
    <title>HELPDESK ADMIN</title>

    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="" />
    <meta name="keywords" content="HTML,CSS,XML,JavaScript" />
    <meta name="author" content="" />


    <link rel="shortcut icon" href="{{asset('img/helpdesk-favico.ico')}}" type="image/x-icon">

    <meta name="robots" content="noindex">


    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/devices.css') }}" rel="stylesheet">
    <link href="{{ asset('css/devices-admin.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery-ui.min.css') }}" rel="stylesheet">
    {{--<link href="{{ asset('css/style.css') }}" rel="stylesheet">--}}
    <link href="{{ asset('css/mystyle.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style-admin.css') }}" rel="stylesheet">

    <!-- FONTS -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700" rel="stylesheet">
    <!-- FONTS -->

    <!-- Scripts -->
    <script
        src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/my.js') }}"></script>
    <script src="{{ asset('js/blueimpgallery.min.js') }}"></script>
    <script src="{{ asset('js/jquery-2.1.4.js') }}"></script>
    <script src="{{ asset('js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/myjquery.js') }}"></script>
    <script src="{{ asset('js/slick.min.js') }}"></script>
    <script src="{{ asset('js/stacktable.min.js') }}"></script>


 <meta property="og:locale" content="cs_CZ">
 <meta property="og:type" content="">
 <meta property="og:title" content="">
 <meta property="og:description" content="">
 <meta property="og:url" content="">
 <meta property="og:site_name" content="">

</head>
<body>
<header class="p30-bb">
 <div class="container flx aicjsb">
     <div class="header-left flx">
         <a class="logo" href="{{route('admin-tickets')}}"><img src="{{asset("img/logo.png")}}" alt="Logo"></a>
         <div class="helpdesk">helpdesk</div>
     </div>
     <div class="header-right flx">
         <div class="user flx">
             <p>
                 <strong>{{Auth::user()->user_name}}</strong>
                 <a href="{{ route('edit-user',['id' =>Auth::user()->id])}}">Můj účet</a><span>|</span>
                 <a href="{{ route('logout') }}">Odhlásit</a>
             </p>
             <img src="{{asset("img/user.svg")}}" alt="Uživatel">
         </div>
     </div>
 </div>
</header>

@include('../partial/flash')
@yield('content')

<footer>
 <div class="container flx aicjsb">
     <p><span>Firma s.r.o.</span> <br />Karla IV. 556/16, Olomouc,  779 00 <br /><strong>t:</strong> <a href="tel:+420777112333">+420777 112 333</a>, <strong>m:</strong> <a href="mailto:test@email.cz">test@email.cz</a></p>
     <a class="logo" href="/"><img src="{{asset("img/logo.png")}}" alt="Logo"></a>
 </div>
</footer>

<div class="overlay"></div>
<a href="#" class="scrollToTop"></a>
</body>

