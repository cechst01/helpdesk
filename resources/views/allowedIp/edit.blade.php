@extends('../layouts/admin')
@section('content')

    @include('partial/adminHeader');

        <div class="page-content">
            <div class="container">
                <form method="post">
                    @csrf
                    @foreach($allowedIps as $allowedIp)
                        <div class="box block w-25">
                            <input type="text" class="" value="{{$allowedIp->ip_address}}" name="allowedIp[]">
                            <a href="" class="remove-button remove-ip-input"><img src="{{asset('img/akcesmazat.svg')}}" alt="Smazat"></a>
                        </div>
                    @endforeach
                    <button type="button" id="add-ip-address" class="button pridathodiny">Přidat ip adresu</button>
                    <div class="center-button">
                        <input type="submit" value="Uložit adresy" class="button">
                    </div>
                </form>
            </div>
        </div>

@endsection