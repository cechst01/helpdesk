@extends('layouts/admin')
@section('content')

    @include('partial/adminHeader');

    <div class="page-content">
        <div class="container">
            @include('../partial/ticketSearchForm',['url' => route('admin-tickets')])
            <form method="post" id="multiple-remove-tickets" action="{{route('delete-tickets')}}">
                @csrf
            <div class="ohrancieni">
                <div class="box">
                    <label for="">Označené:</label>
                    <select name="multiple-choice">
                        <option value="1">Smazat</option>
                    </select>
                    <input type="submit" value="Smazat označené">
                </div>
                <div class="table-responsive">
                    <table>
                        <thead>
                        <tr>
                            <th><input type="checkbox" class="all-checkboxes" name="all-checkboxes"></th>
                            <th>číslo</th>
                            <th>název</th>
                            <th>klient</th>
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
                        <tr>
                            <td><input type="checkbox" name="deletedTickets[]" value="{{$ticket->id}}"></td>
                            <td>{{$ticket->id}}</td>
                            <td class="txt-l"><a href="{{route('show-ticket',['id' => $ticket->id])}}">{{$ticket->title}}</a></td>
                            <td><a href ="{{route('show-client',['id' => $ticket->user->id])}}">{{$ticket->user->user_name}}</a></td>
                            <td class="stav {{$stateClasses[$ticket->state->id]}}"><p><a href="{{route('show-ticket',['id' => $ticket->id])}}">{{$ticket->state->name}}</a></p></td>
                            <td>{{$ticket->type->name}}</td>
                            <td>{{$ticket->created_at}}</td>
                            <td>{{$ticket->date_of_completion_client}}</td>
                            <td>{{$ticket->date_of_completion_leksys}}</td>
                            <td class="akce">
                                <img src="{{asset("img/showmore.svg")}}" alt="show">
                                <ul>
                                    <li><a class="show" href="{{route('show-ticket',['id' => $ticket->id])}}"><img src="{{asset("img/tableshow.svg")}}" title="Náhled" alt="Náhled">Náhled</a></li>
                                    <li><a class="edit" href="{{route('edit-ticket',['id' => $ticket->id])}}"><img src="{{asset("img/tableedit.svg")}}" title="Upravit" alt="Upravit">Upravit</a></li>
                                    <li>
                                        <a class="remove remove-ticket" href="" data-remove-link="{{route('delete-ticket',['id'=> $ticket->id])}}">
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

            <div class="strankovani flx aicjsb">
                <p>Zobrazeno <strong>{{$tickets->count()}}</strong> z {{$tickets->total()}} požadavků</p>
                {{$tickets->appends(['search' => $searchValue,'type' => $typeValue,'state' => $stateValue])->links('partial/paginator')}}


                @if(!Request::get('approved') && !Request::get('deleted') )
                    <div>
                        <a class="button zobrazit" href="{{route('admin-tickets',['approved' => 1])}}">Zobrazit vyřízené</a>
                        <a class="button zobrazit smazane" href="{{route('admin-tickets',['deleted' => 1])}}">Zobrazit smazané</a>
                    </div>
                @else
                    <a class="button zobrazit" href="{{route('admin-tickets')}}">Zobrazit vše</a>
                @endif

            </div>
            </form>
            <form id="remove-ticket-form" method="post" action="" class="none">@csrf</form>
        </div>

    </div>


@endsection