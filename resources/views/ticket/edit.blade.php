@extends('layouts/admin')
@section('content')

    <script src="{{asset('js/date-picker-script.js')}}"></script>
    <section class="title-section p30-bb">
        <div class="container flx aicjsb">
            <h1 class="title"><span>Požadavek č.{{$ticket->id}}</span>{{$ticket->title}}</h1>
            <div class="right-side flx">
                {{--<a class="upravit" href=""><img src="../img/upravit.svg" alt="Upravit">Upravit</a>--}}
                <a class="button zpet" href="{{route('admin-tickets')}}">ZPĚT</a>
            </div>
        </div>
    </section>

    <div class="page-content">
        <div class="container">
            <form method='post' enctype="multipart/form-data">
                @csrf

                <div class="detail-ticket flx">
                    <div class="left-side">
                        <div class="row">
                            <div class="box">
                                <label for="select">Jméno klienta:</label>
                                <span>{{$ticket->user->user_name}}</span>
                            </div>
                            <div class="box">
                                <label for="">Požadované datum dokončení:</label>
                                <input class="datepicker" autocomplete="off" type="text" value="{{$ticket->date_of_completion_client}}" name="date_of_completion_client" disabled>
                            </div>
                            <div class="box">
                                <label for="">Předpokládané datum dokončení:</label>
                                <input class="datepicker" autocomplete="off" type="text" value="{{$ticket->date_of_completion_leksys}}" name="date_of_completion_leksys" >
                                @if ($errors->has('date_of_completion_leksys'))
                                    <span class="input-error">
                                        <strong>{{ $errors->first('date_of_completion_leksys') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="box">
                                <label for="">Stav:</label>
                                <select name="state_id">
                                    @foreach($states as $index => $state)
                                        <option value="{{$state->id}}" @if($ticket->state_id == $state->id)selected @endif {{--title="test"--}}>{{$state->name}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('state_id'))
                                    <span class="input-error">
                                    <strong>{{ $errors->first('state_id') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="box">
                                <label for="select">fakturováno:</label>
                                <div class="checkbox-styled">
                                    <input id="ano" type="radio" name="invoiced" value="1" @if($ticket->invoiced == 1)checked @endif >
                                    <label for="ano">Ano</label>
                                </div>
                                <div class="checkbox-styled">
                                    <input id="ne" type="radio" name="invoiced" value="0" @if($ticket->invoiced == 0)checked @endif>
                                    <label for="ne">Ne</label>
                                </div>
                                @if ($errors->has('invoiced'))
                                    <span class="input-error">
                                        <strong>{{ $errors->first('invoiced') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="box">
                                <label for="">Navrhovaný počet hodin:</label>
                                <input type="text" name="credits_offer" value="{{$ticket->credits_offer}}">
                                @if ($errors->has('credits_offer'))
                                    <span class="input-error">
                                        <strong>{{ $errors->first('credits_offer') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="box">
                                <label for="">Skutečný počet hodin:</label>
                                <input type="text" name="credits_real" value="{{$ticket->credits_real}}">
                                @if ($errors->has('credits_real'))
                                    <span class="input-error">
                                        <strong>{{ $errors->first('credits_real') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="box notification-checkbox">
                                <label>Upozornit zákazníka:</label>
                                <input type="checkbox" name="send_notification" checked>
                            </div>
                        </div>
                    </div>
                    <div class="right-side">
                        <div class="row">
                            <div class="box">
                                <label for="project">Projekt:</label>
                                <input id="project" name="project" type="text" name='title' value="{{$ticket->project}}">
                                @if ($errors->has('project'))
                                    <span class="input-error">
                                        <strong>{{ $errors->first('project') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="box">
                                <label for="nazev">Název požadavku:</label>
                                <input id="nazev" type="text" name='title' value="{{$ticket->title}}">
                                @if ($errors->has('title'))
                                    <span class="input-error">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="box">
                                <label for="popis">Popis:</label>
                                <textarea id="popis" name='content'>{{$ticket->content}}</textarea>
                                @if ($errors->has('content'))
                                    <span class="input-error">
                                        <strong>{{ $errors->first('content') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="box">
                                <label for="private_note">Soukromá poznámka:</label>
                                <textarea id="private_note" name='private_note'>{{$ticket->private_note}}</textarea>
                                @if ($errors->has('private_note'))
                                    <span class="input-error">
                                        <strong>{{ $errors->first('private_note') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="box">
                                <label for="typ">Typ:</label>
                                <select id="typ"name='type_id'>
                                    @foreach($types as $type)
                                        <option value='{{$type->id}}' @if($ticket->type_id == $type->id)selected @endif>{{$type->name}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('type_id'))
                                    <span class="input-error">
                                        <strong>{{ $errors->first('type_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="box" id="files">

                                @if($ticket->attachments)
                                    @foreach($ticket->attachments as $attachment)
                                        <div class="priloha"><div>{{$attachment->name}}</div>
                                            <a title="Odebrat" href="#" class="remove-attachment" data-remove-link="{{route('delete-attachment',['id' => $attachment->id])}}">
                                                <img src="{{asset("img/smazat.png")}}" alt="Odebrat">
                                            </a>
                                        </div>
                                    @endforeach
                                @endif
                                <div id='new-files'>
                                </div>
                                @if ($errors->has('attachments.*'))
                                    <span class="input-error">
                                        <strong>{{ $errors->first('attachments.*') }}</strong>
                                    </span>
                                @endif
                                <div class="file-manager">
                                    <input id="uploadfile" type="file" name="attachments[]" multiple data-edit="1">
                                    <label for="uploadfile">přidat přílohu</label>
                                    @if ($errors->has('attachments.*'))
                                        <span class="input-error">
                                            <strong>{{ $errors->first('attachments.*') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="buttons-left">
                    <button class="button" type="submit" name="button">uložit </button>
                    {{--a class="button red" href="">uzavřít </a>--}}
                </div>
            </form>
            <form id='remove-attachment-form' method='post' action=''>@csrf</form>
        </div>
    </div>

@endsection