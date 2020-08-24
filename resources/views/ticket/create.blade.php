@extends('layouts/app')
@section('content')
    <section class="title-section p30-bb">
        <div class="container flx aicjsb">
            <h1 class="title">Nový požadavek</h1>
            <div class="right-side flx">
                <a class="button zpet" href="{{route('dashboard')}}">ZPĚT</a>
            </div>
        </div>
    </section>

    <script src="{{asset('js/date-picker-script.js')}}"></script>

    <div class="page-content">
        <div class="container">
            <div class="filtration flx">
                <form method='post' enctype="multipart/form-data">
                    @csrf
                    <div class="filtration-content flx fdc">
                        <div class="box">
                            <label for="project">Projekt:</label>
                            <input id="project" name="project" type="text" name='title' value="{{old('project')}}">
                            @if ($errors->has('project'))
                                <span class="input-error">
                                <strong>{{ $errors->first('project') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="box">
                            <label for="nazevpozadavku">Název požadavku:</label>
                            <input id="nazevpozadavku" type="text" name='title' value="{{old('title')}}">
                            @if ($errors->has('title'))
                                <span class="input-error">
                                <strong>{{ $errors->first('title') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="box">
                            <label for="popis">Popis:</label>
                            <textarea id="popis" name='content'>{{old('content')}}</textarea>
                            @if ($errors->has('content'))
                                <span class="input-error">
                                    <strong>{{ $errors->first('content') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="box">
                            <label for="datepicker">Požadovaný termín dodání:</label>
                            <input id="datepicker" autocomplete="off" class="datepicker" type="text" name='date_of_completion_client' value="{{old('date_of_completion_client')}}">
                            @if ($errors->has('date_of_completion_client'))
                                <span class="input-error">
                                    <strong>{{ $errors->first('date_of_completion_client') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="box">
                            <label for="">Typ:</label>
                            <select name='type_id'>
                                @foreach($types as $type)
                                    <option value='{{$type->id}}' @if($type->id == old('type_id'))selected="selected"@endif>{{$type->name}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('type_id'))
                                <span class="input-error">
                                    <strong>{{ $errors->first('type_id') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="box">
                            <label for="">PŘÍLOHY:</label>
                            <div id="files">

                            </div>
                        </div>
                        <div class="file-manager">
                            <input id="uploadfile" type="file" name="attachments[]" multiple>
                            <label for="uploadfile">přidat přílohu</label>
                            @if ($errors->has('attachments.*'))
                                <span class="input-error">
                                    <strong>{{ $errors->first('attachments.*') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="informace">
                            <p>Založením požadavku Vám bude automaticky odečteno 15 minut z času technické podpory.</p>
                            <p>V případě, že bude požadavek brán jako reklamace, nebude Vám odečtený čas účtován.</p>
                        </div>
                    </div>
                    <button class="button" type="submit" name="button">uložit a odeslat</button>
                </form>
            </div>
        </div>
    </div>
@endsection