@extends('layouts/app')
@section('content')

    <script src="{{asset('js/date-picker-script.js')}}"></script>
    <section class="title-section p30-bb">
        <div class="container flx aicjsb">
            <h1 class="title"><span>Požadavek č. {{$ticket->id}}</span>{{$ticket->title}}</h1>
            <div class="right-side flx">
                @if(Auth::user()->admin == 1)
                    <a class="upravit" href="{{route('update-ticket',['id'=> $ticket->id])}}"><img src="{{asset("img/upravit.svg")}}" alt="Upravit">Upravit</a>
                @endif
                @php
                    $url = URL::previous() != route('create-ticket') && URL::previous() != URL::current() ? URL::previous() : route('dashboard');
                @endphp
                <a class="button zpet" href="{{$url}}">ZPĚT</a>


            </div>
        </div>
    </section>

    <div class="page-content">
        <div class="container">
            <div class="detail-ticket flx">
                <div class="left-side">
                    <h2 class="title2">klient:</h2>
                    <div class="user-desc">
                        <p><strong>{{$ticket->user->user_name}}</strong></p>
                        <p>E: {{$ticket->user->email}}</p>
                        <p>T: {{$ticket->user->phone_number}}</p>
                    </div>
                    <h2 class="title2">Stav:</h2>
                    <div class="stav {{$stateClasses[$ticket->state->id]}}">
                        <p>{{$ticket->state->name}}</p>
                    </div>
                    @if(Auth::user()->admin == 1)
                        <h2 class="title2">fakturováno:</h2>
                        <p class="fatkurace-ano-ne">{{$ticket->invoiced ? "Ano" : "Ne"}}</p>
                    @endif
                    <h2 class="title2">Zadáno:</h2>
                    <p>{{$ticket->created_at}}</p>
                    @if($ticket->state->id == '6') {{-- stav schválení rozpočtu --}}
                        <table>
                            <tr><th>Požadované datum dokončení:</th></tr>
                            <tr><td>{{$ticket->date_of_completion_client}}</td></tr>
                            <tr><th>Předpokládané datum dokončení:</th></tr>
                            <tr><td>{{$ticket->date_of_completion_leksys}}</td></tr>
                            <tr><th>rozpočet hodin:</th></tr>
                            <tr><td>{{$ticket->credits_offer}}</td></tr>
                        </table>
                        @if(Auth::user()->admin != 1)
                            <div class="buttons flx aicjsb">
                                <form method="post" action="{{route('approve-ticket-credits',['id' => $ticket->id])}}">
                                    @csrf
                                    <input type="submit" class="button" value="Schválit">
                                </form>
                                <form method="post" action="{{route('reject-ticket-credits',['id' => $ticket->id])}}">
                                    @csrf
                                    <input type="submit" class="button red" value="Zamítnout">
                                </form>
                            </div>
                        @endif
                    @else

                        @if($ticket->date_of_completion_leksys)
                            <h2 class="title2">Požadované datum dokončení:</h2>
                            <p>{{$ticket->date_of_completion_leksys}}</p>
                        @endif
                        @if($ticket->credits_offer)
                            <h2 class="title2">Návrh hodin:</h2>
                            <p>{{$ticket->credits_offer}}</p>
                        @endif
                        @if($ticket->credits_real)
                            <h2 class="title2">Skutečný počet hodin:</h2>
                            <p>{{$ticket->credits_real}}</p>
                        @endif
                    @endif
                </div>
                <div class="right-side">
                    @if(Auth::user()->admin == 1 && $ticket->state_id == 1 /* stav Nový ticket*/)
                        <div class="approve-form">
                            <h2 class="title2">Rychlé zpracování:</h2>
                            {{-- form musi mit akci, protoze jen na post uz pridavam komenty--}}
                            <form method="post" action="{{route('process-ticket',['id' => $ticket->id])}}">
                                @csrf
                                <div class="box">
                                    <label for="">Předpokládané datum dokončení:</label>
                                    <input  type="text" name="date_of_completion" autocomplete="off" class="datepicker">
                                    @if ($errors->has('date_of_completion'))
                                        <span class="input-error">
                                            <strong>{{ $errors->first('date_of_completion') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                @if($ticket->type_id == 1 /* Nová zakázka */)
                                    <div class="box">
                                        <label for="">Navrhovaný počet hodin:</label>
                                        <input  type="text" name="credits_offer">
                                        @if ($errors->has('credits_offer'))
                                            <span class="input-error">
                                                <strong>{{ $errors->first('credits_offer') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                @endif
                                @php
                                    $value = $ticket->type_id == 1 ? 'Ke schválení rozpočtu' : 'Ke zpracování';
                                @endphp
                                <div class="mb-2">
                                    <input type="submit" value="{{$value}}" class="button">
                                </div>
                            </form>
                        </div>
                    @endif
                    <h2 class="title2">Popis:</h2>
                    <p>
                        {!!  $ticket->getContentWebalize()!!}
                    </p>
                    <h2 class="title2">Typ:</h2>
                    <p><strong>{{$ticket->type->name}}</strong></p>
                    @if($ticket->type_id == 1 /* Nová zakázka */)
                        <div class="dsc">
                            Nejedná se o reklamaci dodané služby, nebo nedodělek a jednotlivé služby budou účtovány dle <a target="_blank" href="">aktuálního sazebníku</a> na fakturu, nebo poskytnuty jinak v rámci smlouvy.
                        </div>
                    @endif

                    @if(Auth::user()->admin == 1)
                        <h2 class="title2">Soukromá poznámka:</h2>
                        <p>
                            {{$ticket->private_note}}
                        </p>
                    @endif

                    @if(!$ticket->attachments->isEmpty())
                        <h2 class="title2">PŘÍLOHY:</h2>
                        <div class='attachments'>
                            @foreach($ticket->attachments as $attachment)
                                <div class="priloha">
                                    <div><a href='{{URL::asset("attachments/".$attachment->url)}}' target="_blank">{{$attachment->name}}</a></div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <div class='comments'>
                        @php($leksysSide = (!empty($ticket->comments->toArray()) && $ticket->comments->first()->leksys == 0) ? 'right' : 'left' )
                        @php($side = $leksysSide == 'right' ? 'left' : 'right' )
                        @foreach($ticket->comments as $comment)
                            <div class="@if($comment->leksys){{$leksysSide}}@else{{$side}}@endif comment">
                                <strong>{{$comment->author_name}}</strong><i>{{$comment->created_at}}</i>
                                <p>{{$comment->content}}</p>
                            </div>
                        @endforeach
                    </div>

                    <div class="clear">
                        @if($ticket->state->id == 9 || Auth::user()->admin){{-- stav kontrola zákazníkem --}}
                            @if(!Auth::user()->admin)
                                <div>
                                    <form method="post" action="{{route('approve-ticket',['id' => $ticket->id])}}">
                                        @csrf
                                        <button type='submit' class="button">Schválit</button>
                                    </form>
                                    <br>
                                    <button type='button' class='show-comment-form button red'>Připomínkovat</button>
                                </div>
                            @endif
                            <div id="comment-form-div" class="{{Auth::user()->admin ? '' : 'none'}}">
                                <form method="post" action="{{route('store-comment',['id' => $ticket->id])}}">
                                    @csrf
                                    <div class="box">
                                        <label>Jméno:<input type="text" name="author_name" value="{{Auth::user()->user_name}}"></label>
                                        @if ($errors->has('author_name'))
                                            <span class="">
                                                <strong>{{ $errors->first('author_name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div div class="box">
                                        <label>Popis:<textarea name="content"></textarea></label>
                                        @if ($errors->has('content'))
                                            <span class="">
                                                <strong>{{ $errors->first('content') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div><input type="submit" value="Odeslat připomínku" class="button"></div>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @if(Auth::user()->admin == 1 && $ticket->history->isNotEmpty())
                <div>
                    <h2 class="title-center">Historie stavů:</h2>
                    <table class="history-table">
                        <tr>
                            <th>Datum:</th>
                            <th>Uživatel:</th>
                            <th>Starý stav:</th>
                            <th>Nový stav:</th>
                        </tr>
                        @foreach($ticket->history as $history)
                            <tr>
                                <td>{{$history->created_at}}</td>
                                <td>{{$history->user->user_name}}</td>
                                <td>{{$history->oldState->name}}</td>
                                <td>{{$history->newState->name}}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection