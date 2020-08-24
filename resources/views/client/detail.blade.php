@extends('layouts/admin')
@section('content')

    <section class="title-section p30-bb">
        <div class="container flx aicjsb">
            <h1 class="title"><span>{{$user->company_name}}</span>{{$user->user_name}}</h1>
            <div class="right-side flx">
                <div class="time">
                    @if($user->actualCredits)
                    <p class="time-count">Zbývá hodin:<strong id="demo">{{$user->actualCredits->creditsInHours}}</strong></p>
                    <p class="time-validity">Platnost do {{$user->actualCredits->valid_to}}</p>
                    @else
                        <span>Žádné hodiny nepřiděleny</span>
                    @endif
                </div>
                @php
                    $url = URL::previous() == route('admin-tickets') || URL::previous() == route('admin-clients') ? URL::previous() : route('admin-clients');
                @endphp
                <a class="button zpet" href="{{$url}}">ZPĚT</a>
            </div>
        </div>
    </section>
    <div class="page-content">
        <div class="container">
            @include('../partial/ticketSearchForm',['url' => route('show-client',['id' => $user->id])])
            <div class="table-responsive">
                <table>
                    <thead>
                    <tr>
                        <th>číslo</th>
                        <th>název</th>
                        <th>stav</th>
                        <th>typ</th>
                        <th>datum <br>vložení</th>
                        <th>požadované <br>datum dokončení</th>
                        <th>předpokládané <br>datum dokončení</th>
                        <th>&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($tickets as $ticket)
                    <tr class="{{$ticket->state->name == 'Ke schválení' ? 'neschavelene' : ''}}">
                        <td>{{$ticket->id}}</td>
                        <td class="txt-l">{{$ticket->title}}</td>
                        <td class="stav {{$stateClasses[$ticket->state->id]}}"><p>{{$ticket->state->name}}</p></td>
                        <td>{{$ticket->type->name}}</td>
                        <td>{{$ticket->created_at}}</td>
                        <td>{{$ticket->date_of_completion_client}}</td>
                        <td>{{$ticket->date_of_completion_leksys}}</td>
                        <td class="akce"><a title="Zobrazit" href="{{route('show-ticket',['id' => $ticket->id])}}"><img src="{{asset("img/detail.svg")}}" alt="detail"></a></td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="strankovani flx aicjsb">
                <p>Zobrazeno <strong>{{$tickets->count()}}</strong> z {{$tickets->total()}} požadavků</p>
                {{$tickets->appends(['search' => $searchValue,'type' => $typeValue,'state' => $stateValue])->links('partial/paginator')}}
                @if(!Request::get('approved'))
                    <a class="button zobrazit" href="{{route('show-client',['approved' => 1, 'id' => $user->id])}}">Zobrazit schválené</a>
                @else
                    <a class="button zobrazit" href="{{route('show-client',['id' => $user->id])}}">Zobrazit vše</a>
                @endif
            </div>
        </div>
    </div>

@endsection