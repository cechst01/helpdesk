@extends('../layouts/admin')
@section('content')

    @include('partial/adminHeader');
    <div class="page-content">
        <div class="container">
            <form method='get'>
                <div class="filtration flx">
                    <div class="filtration-content flx">
                        <div class="box">
                            <input type="text" placeholder="Zadejte jméno" name='search' value='{{$searchValue}}'>
                        </div>
                    </div>
                    <div class="filtration-buttons flx">
                        <button class="button" href="">Zobrazit</button>
                        <a class="button zrusit" href="{{route('admin-clients')}}">Zrušit</a>
                    </div>
                </div>
            </form>
            <form method="post" action="{{route('delete-clients')}}">
                @csrf
            <div class="ohrancieni">
                <div class="box">
                    <label for="">Označené:</label>
                    <select name="">
                        <option valeu='1'>Smazat</option>
                    </select>
                    <input type="submit" value="Smazat označené">
                </div>
                <div class="table-responsive">
                    <table>
                        <thead>
                        <tr>
                            <th><input type="checkbox" class='all-checkboxes'></th>
                            <th>Jméno klienta (kredity)</th>
                            <th>Název firmy</th>
                            <th>Telefon</th>
                            <th>E-mail</th>
                            <th>Poslední aktivita</th>
                            <th>&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody>
                        {{--dd($clients[0]->actualCredits)--}}
                        @foreach($clients as $client)
                        <tr>
                            <td><input type='checkbox' value="{{$client->id}}" name="deletedClients[]"></td>
                            @php
                                $actualCredits = $client->actualCredits ? $client->actualCredits->count: 0;
                                $class = $actualCredits > 0 ? 'kredit' : 'kredit red';
                            @endphp
                            <td class="txt-l">{{$client->user_name}} <p class="{{$class}}">{{$actualCredits}}</p></td>
                            <td class="txt-l">{{$client->company_name}}</td>
                            <td class="txt-l">{{$client->phone_number}}</td>
                            <td class="txt-l">{{$client->email}}</td>
                            <td>{{$client->last_activity}}</td>
                            <td class="akce">
                                <img src="{{asset("img/showmore.svg")}}" alt="show">
                                <ul>
                                    <li><a class="login" href="{{route('super-login',['id'=> $client->id])}}"><img src="{{asset("img/tablelogin.svg")}}" title="Přihlásit" alt="Přihlásit">Přihlásit</a></li>
                                    <li><a class="show" href="{{route('show-client',['id' => $client->id])}}"><img src="{{asset("img/tableshow.svg")}}" title="Náhled" alt="Náhled">Náhled</a></li>
                                    <li><a class="edit" href="{{route('edit-client',['id' => $client->id])}}"><img src="{{asset("img/tableedit.svg")}}" title="Upravit" alt="Upravit">Upravit</a></li>
                                    <li>
                                        <a href="#" class=" remove remove-client" data-remove-link="{{route('delete-client',['id' => $client->id])}}">
                                            <img src="{{asset("img/tableremove.svg")}}" title="Smazat" alt="Smazat">Smazat
                                        </a>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            </form>
            <form method='post' id="remove-client-form" class="none" action=''>@csrf</form>
            <div class="strankovani flx aicjsb">
                <p>Zobrazeno <strong>{{$clients->count()}}</strong> z {{$clients->total()}} uživatelů</p>
                {{$clients->appends(['search' => $searchValue])->links('partial/paginator')}}
                <p></p>
            </div>
        </div>
    </div>
@endsection