@extends('../layouts/admin')
@section('content')

    @include('partial/adminHeader');

    <div class="page-content">
        <div class="container">
            <form method='get'>
                <div class="filtration flx">
                    <div class="filtration-content flx">
                        <div class="box">
                            <input type="text" placeholder="Zadejte jméno" name='search' value=''>
                        </div>
                    </div>
                    <div class="filtration-buttons flx">
                        <button class="button" href="">Zobrazit</button>
                        <a class="button zrusit" href="{{route('show-login-history')}}">Zrušit</a>
                    </div>
                </div>
            </form>
            <table>
                <tr>
                    <th>Jméno uživatele</th>
                    <th>Ip adresa</th>
                    <th>Datum přihlášení</th>
                    <th>Úspěšné</th>
                </tr>
                @foreach($histories as $history)
                    <tr>
                        <td>{{$history->user ? $history->user->user_name : 'Neznámý uživatel'}}</td>
                        <td>{{$history->ip_address}}</td>
                        <td>{{$history->created_at}}</td>
                        <td>{{$history->isSuccess()}}</td>
                    </tr>
                @endforeach
            </table>
            <div class="strankovani flx aicjsb">
                <p>Zobrazeno <strong>{{$histories->count()}}</strong> z {{$histories->total()}} záznamů.</p>
                {{$histories->links('partial/paginator')}}
                <p></p>
            </div>
        </div>
    </div>

@endsection