@extends('layouts.admin')

@section('content')
    <section class="title-section p30-bb">
        <div class="container flx aicjsb">
            <h1 class="title">Editace klienta</h1>
            <div class="right-side flx">
                <a class="smazat-klienta remove-client" href="" data-remove-link="{{route('delete-client',['id' => $user->id])}}"><img src="{{asset("img/smazat.png")}}" alt="Smazat">Smazat klienta</a>
                <a class="button zpet" href="{{URL::previous() != URL::current() ? URl::previous() : route('admin-clients') }}">ZPĚT</a>
            </div>
        </div>
    </section>

    <div class="page-content">
        <div class="container">
            <div class="filtration flx three-forms">
                <form method="post" action="{{route('update-client',['id' => $user->id])}}">
                    @csrf
                    <div class="box">
                        <label for="">Aktivní klient:</label>
                        <label class="switch">
                            <input type="checkbox" name="enabled" {{$user->enabled == 1 ? "checked" : ""}}>
                            <span class="slider"></span>
                        </label>
                    </div>
                    <h2 class="title">Obecné informace</h2>
                    <div class="filtration-content flx">
                        <div class="box">
                            <label for="jmeno">Jméno a příjmení:</label>
                            <input id="jmeno" type="text" name="user_name" value="{{$user->user_name}}">
                            @if ($errors->has('user_name'))
                                <span class="info input-error">
                                    <strong>{{ $errors->first('user_name') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="box">
                            <label for="firmname">Název firmy:</label>
                            <input id="firmname" type="text" name="company_name" value="{{$user->company_name}}">
                            @if ($errors->has('company_name'))
                                <span class="info input-error">
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
                            <input id="telefon" type="tel" name="phone_number" value="{{$user->phone_number}}">
                            @if ($errors->has('phone_number'))
                                    <span class="info input-error">
                                        <strong>{{ $errors->first('phone_number') }}</strong>
                                        </span>
                            @endif
                        </div>
                        <div class="box">
                            <label for="email">E-mail:</label>
                            <input id="email" type="email" name="email" value="{{$user->email}}">
                            @if ($errors->has('email'))
                                <span class="info input-error">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="box">
                            <label for="pw">heslo:</label>
                            <input id="pw" type="password" name="password">
                            @if ($errors->has('password'))
                                <span class="info input-error">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="box">
                            <label for="pw2">heslo znovu:</label>
                            <input id="pw2" type="password" name="password_confirmation">
                            @if ($errors->has('password_confirmation'))
                                <span class="info input-error">
                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <section class="editable-table">

                            <h2 class="title">Přidělené hodiny</h2>
                            <div class="table-responsive">
                                <table>
                                    <thead>
                                    <tr>
                                        <th>POČET HODIN <br>(zbývá)</th>
                                        <th>POČET HODIN <br>(vyčerpáno)</th>
                                        <th>Platnost (od)</th>
                                        <th>Platnost (do)</th>
                                        <th>Akce</th>
                                    </tr>
                                    </thead>
                                    <tbody id="credit-table-body">
                                    @foreach($user->credits as $credit)

                                    <tr>
                                        <td><input type="text" name="count[]" id="" value="{{$credit->count}}" disabled></td>
                                        <td><input type="text" value="{{$credit->removed_count}}" name="removed_count[]" disabled></td>
                                        <td><input type="text" autocomplete="off" value="{{$credit->valid_from}}" name="valid_from[]" class="datepicker" disabled></td>
                                        <td><input type="text" autocomplete="off" name="valid_to[]" value="{{$credit->valid_to}}" class="datepicker" id="datepicker" disabled></td>
                                        <td class="editovat">
                                            <a title="Upravit" class="update-credit-row" href=""><img src="{{asset("img/akceedit.svg")}}" alt="Upravit"></a>
                                            <a title="Smazat" class="remove-credit-row" href=""><img src="{{asset("img/akcesmazat.svg")}}" alt="Smazat"></a>
                                            <a class="button save-credit-row" href="#">uložit změny</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <div>
                                    @if ($errors->has('count.*'))
                                        <span class="info input-error">
                                            <strong>{{ $errors->first('count.*') }}</strong>
                                        </span>
                                    @endif
                                    @if ($errors->has('valid_from.*'))
                                        <span class="info input-error">
                                            <strong>{{ $errors->first('valid_from.*') }}</strong>
                                        </span>
                                    @endif
                                    @if ($errors->has('valid_to.*'))
                                        <span class="info input-error">
                                            <strong>{{ $errors->first('valid_to.*') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <button type="button" class="button pridathodiny">Přidat hodiny</button>
                            <div class="center-button">
                                <button class="button enabled-disabled" type="submit" name="button">Uložit změny</button>
                            </div>
                    </section>
                </form>
                <form id="remove-client-form" class="none" method="post" action="">@csrf</form>
            </div>
            <script src="{{asset('js/date-picker-script.js')}}"></script>
        </div>
    </div>

@endsection