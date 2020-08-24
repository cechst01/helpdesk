<section class="tab-section">
    <div class="container flx aicjsb">
        <ul class="tabs">
            <li class="{{Request::url() == route('admin-tickets') ? 'active' : ''}}"><a href="{{route('admin-tickets')}}">Tickety</a></li>
            <li class="{{Request::url() == route('admin-clients') ? 'active' : ''}}"><a href="{{route('admin-clients')}}">Klienti{{--<span></span>--}}</a></li>
            <li class="{{Request::url() == route('show-login-history') ? 'active' : ''}}"><a href="{{route('show-login-history')}}">Logování{{--<span></span>--}}</a></li>
            <li class="{{Request::url() == route('edit-allowed-ip') ? 'active' : ''}}"><a href="{{route('edit-allowed-ip')}}">Ip adresy{{--<span></span>--}}</a></li>
        </ul>
        @if(Request::url() == route('admin-clients'))
         <a class="button add" href="{{route('create-client')}}">Nový klient</a>
        @endif
    </div>
</section>
