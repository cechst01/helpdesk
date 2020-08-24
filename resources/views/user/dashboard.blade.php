@extends('layouts.app')
@section('content')

<section class="title-section p30-bb">
    <div class="container flx aicjsb">
        <h1 class="title">Přehled požadavků</h1>
        <div class="right-side flx">
            <div class="time">
                @if($user->actualCredits)
                    <p class="time-count">Zbývá hodin:<strong id="demo">{{$user->actualCredits->creditsInHours}}</strong></p>
                    <p class="time-validity">Platnost do {{$user->actualCredits->valid_to}}</p>
                @else
                    Žádné hodiny nepřiděleny.
                @endif
            </div>
            <a class="button add" href="{{action('TicketController@create')}}">Nový požadavek</a>
        </div>
    </div>
</section>

<div class="page-content">
    <div class="container">
        @if($tickets->count() || 1)
        @include('../partial/ticketSearchForm',['url' => route('dashboard')])
        <div class="table-responsive">
            <table>
                <thead>
                <tr>
                    <th>číslo</th>
                    <th>název</th>
                    <th>stav</th>
                    <th>typ</th>
                    <th>datum vložení</th>
                    <th>Požadované datum dokončení</th>
                    <th>Předpokládané datum dokončení</th>
                    <th>&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                @foreach($tickets as $ticket)
                    <tr class="{{$ticket->state->id == 4 ? 'neschavelene' : ''}}">
                        <td>{{$ticket->id}}</td>
                        <td class="txt-l">{{$ticket->title}}</td>
                        <td class="stav {{$stateClasses[$ticket->state->id]}}"><p>{{$ticket->state->name}}</p></td>
                        <td>{{$ticket->type->name}}</td>
                        <td>{{$ticket->created_at}}</td>
                        <td>{{$ticket->date_of_completion_client}}</td>
                        <td>{{$ticket->date_of_completion_leksys}}</td>
                        <td class="akce"><a href="{{route('show-ticket',['ticketId' => $ticket->id])}}" title="Zobrazit"><img src="{{asset("img/detail.svg")}}" alt="detail"></a></td>

                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="strankovani flx aicjsb">
            <p>Zobrazeno <strong>{{$tickets->count()}}</strong> z {{$tickets->total()}} požadavků</p>
            {{$tickets->appends(['search' => $searchValue,'type' => $typeValue,'state' => $stateValue])->links('partial/paginator')}}


            @if(!Request::get('approved'))
                <a class="button zobrazit" href="{{route('dashboard',['approved' => 1])}}">Zobrazit schválené</a>
            @else
                <a class="button zobrazit" href="{{route('dashboard')}}">Zobrazit vše</a>
            @endif

        </div>
            @endif
    </div>
</div>

@endsection