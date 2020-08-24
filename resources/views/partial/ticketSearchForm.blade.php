<form method="get">
    <div class="filtration flx">
        <div class="filtration-content flx">
            <div class="box"><input type="text" name="search" value="{{$searchValue}}" placeholder="Zadejte číslo nebo název"></div>
            <div class="box">
                <label for="">Stav:</label>
                <select name="state">
                    <option value="0">Vše</option>
                    @foreach($states as $state)
                        <option value="{{$state->id}}" @if($state->id == $stateValue) selected @endif>{{$state->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="box">
                <label for="">Typ:</label>
                <select name="type">
                    <option value="0">Vše</option>
                    @foreach($types as $type)
                        <option value="{{$type->id}}"@if($type->id == $typeValue) selected @endif>{{$type->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="filtration-buttons flx">
            <button class="button">Zobrazit</button>
            @if(!Request::get('approved'))
                <a class="button zrusit" href="{{$url}}">Zrušit</a>
            @else
                <input type="hidden" name="approved" value="1">
                <a class="button zrusit" href="{{$url.'?approved=1'}}">Zrušit</a>
            @endif
        </div>
    </div>
</form>