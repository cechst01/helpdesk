<h1>Založení ticketu <a href="{{route('show-ticket',['id' => $ticket->id])}}">č. {{$ticket->id}} s názvem {{$ticket->title}}.</a></h1>
<p>
    Vážený zákazníku, Váš požadavek byl uložen ke zpracování a v nejkratším možném čase se Vám budeme věnovat.
</p>
<br>
<h2>{{$ticket->title}}({{$ticket->project}})</h2>
<p>{!!$ticket->getContentWebalize()!!}</p>

