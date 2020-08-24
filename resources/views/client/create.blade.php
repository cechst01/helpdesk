@extends('layouts/admin')
@section('content')
    <section class="title-section p30-bb">
        <div class="container flx aicjsb">
            <h1 class="title">Nový klient</h1>
            <div class="right-side flx">
                <a class="button zpet" href="{{route('admin-clients')}}">ZPĚT</a>
            </div>
        </div>
    </section>
    <div class="page-content">
        <div class="container">
            <div class="filtration flx three-forms">
                <form  method="post">
                    @csrf
                    <h2 class="title">Obecné informace</h2>
                    <div class="filtration-content flx">
                        <div class="box">
                            <label for="jmeno">Jméno a příjmení:</label>
                            <input id="jmeno" type="text" name="user_name" value="{{old('user_name')}}">
                            @if ($errors->has('user_name'))
                                <span class="input-error">
                                    <strong>{{ $errors->first('user_name') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="box">
                            <label for="firmname">Název firmy:</label>
                            <input id="firmname" type="text" name="company_name" value="{{old('company_name')}}">
                            @if ($errors->has('company_name'))
                                <span class="input-error">
                                    <strong>{{ $errors->first('company_name') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="box specialbox">
                            <label for="telefon">Telefon:</label>
                            <div class="radio-map">
                                <input id="cze" type="radio" name="narodnost" checked><label for="cze"><img src="{{asset("img/cze.png")}}" alt="cze">+420</label>
                                <input id="svk" type="radio" name="narodnost"><label for="svk"><img src="{{asset("img/svk.png")}}" alt="cze">+421</label>
                            </div>
                            <input id="telefon" type="tel" name="phone_number" value="{{old('phone_number')}}">
                            @if ($errors->has('phone_number'))
                                <span class="input-error">
                                    <strong>{{ $errors->first('phone_number') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="box">
                            <label for="email">E-mail:</label>
                            <input id="email" type="email" name="email" value="{{old('email')}}">
                            @if ($errors->has('email'))
                                <span class="input-error">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="box">
                            <label for="pw">heslo: (min. 7 znaků)</label>
                            <input id="pw" type="password" name="password">
                            @if ($errors->has('password'))
                                <span class="input-error">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="box">
                            <label for="pw2">heslo znovu:</label>
                            <input id="pw2" type="password" name="password_confirmation">
                            @if ($errors->has('password_confirmation'))
                                <span class="input-error">
                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="box">
                        <button  type="button" id="generate-password" class="button zobrazit">Vygenerovat</button>
                        <button type="button" id="copy-to-clipboard" class="button zobrazit">Kopírovat</button>
                    </div>

            <script src="{{asset('js/date-picker-script.js')}}"></script>
            <section class="editable-hours">
                <h2 class="title">Přidělené hodiny</h2>
                <div>
                    @if ($errors->has('count.*'))
                        <span class="input-error">
                        <strong>{{ $errors->first('count.*') }}</strong>
                    </span>
                    @endif
                    @if ($errors->has('valid_from.*'))
                        <span class="input-error">
                        <strong>{{ $errors->first('valid_from.*') }}</strong>
                    </span>
                    @endif
                    @if ($errors->has('valid_to.*'))
                        <span class="input-error">
                        <strong>{{ $errors->first('valid_to.*') }}</strong>
                    </span>
                    @endif
                </div>

                <button type="button" id="add-credit" class="button pridathodiny">Přidat hodiny</button>
                <div class="center-button">
                    <button class="button" type="submit" name="button">založit klienta</button>
                </div>
            </section>
                </form>
            </div>
        </div>
    </div>
@endsection