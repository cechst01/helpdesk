<h1><a href="{{route('show-ticket',['id' => $ticket->id])}}" >Váš ticket č. {{$ticket->id}} s názvem {{$ticket->title}} byl změněn.</a></h1>

        @foreach($changes as $change)
        <p>
            {{$change}}
        </p>
        @endforeach
<br>
<h2>{{$ticket->title}}</h2>
<p>{!!$ticket->getContentWebalize()!!}</p>