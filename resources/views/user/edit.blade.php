@extends('layouts/app')
@section('content')
    <section class="title-section p30-bb">
        <div class="container flx aicjsb">
            <h1 class="title">Moje údaje</h1>
            <div class="right-side flx">
                <a class="button zpet" href="{{route('dashboard')}}">ZPĚT</a>
            </div>
        </div>
    </section>
    <div class="page-content">
        <div class="container">
            <div class="filtration flx three-forms">
                <form method="post">
                    @csrf
                    <div class="filtration-content flx">
                        <div class="box">
                            <label for="jmeno">Jméno (NÁZEV FIRMY):</label>
                            <input id="jmeno" type="text" name="user_name" value="{{$user->user_name}}">
                            @if ($errors->has('user_name'))
                                <span class="input-error">
                                    <strong>{{ $errors->first('user_name') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="box specialbox">
                            <label for="telefon">Telefon:</label>
                            <div class="radio-map">
                                <input id="cze" type="radio" name="narodnost" checked><label for="cze"><img src="{{asset("img/cze.png")}}" alt="cze">+420</label>
                                <input id="svk" type="radio" name="narodnost"><label for="svk"><img src="{{asset("img/svk.png")}}" alt="svk">+421</label>
                            </div>
                            <input id="telefon" type="tel" name="phone_number" value="{{$user->phone_number}}">
                            @if ($errors->has('phone_number'))
                                <span class="input-error">
                                    <strong>{{ $errors->first('phone_number') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="box">
                            <label for="email">E-mail:</label>
                            <input id="email" type="email" name="email" value="{{$user->email}}">
                            @if ($errors->has('email'))
                                <span class="input-error">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="box">
                            <label for="pw">Stávající heslo:</label>
                            <input id="pw" type="password" name="old_password">

                        </div>
                        <div class="box">
                            <label for="pw2">Nové heslo:</label>
                            <input id="pw2" type="password" name="password">
                            @if ($errors->has('password'))
                                <span class="input-error">
                                    <strong>{{ $errors->first('password') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="box">
                            <label for="pw3">Potvrzení hesla:</label>
                            <input id="pw3" type="password"  name="password_confirmation">
                            @if ($errors->has('password_confirmation'))
                                <span class="input-error">
                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                </span>
                            @endif
                            {{--<span class="info">Hesla se neshodují.  Zadejte to stejné heslo znovu!</span>--}}
                        </div>
                        <div class="box mt60-border"><button class="button" type="submit" name="button">uložit změny</button></div>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection