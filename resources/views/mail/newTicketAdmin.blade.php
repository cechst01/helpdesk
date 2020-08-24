<h1><a href="{{route('show-ticket',['id' => $ticket->id])}}">Nový ticket č.{{$ticket->id}}</a></h1>
<p>V helpdesku byl založen nový ticket uživatelem {{$ticket->user->user_name}} ({{$ticket->user->company_name}}) s požadovaným datem dokončení: {{$ticket->date_of_completion_client}}.</p>
<br>
<h2>{{$ticket->title}}({{$ticket->project}})</h2>
<p>{!!$ticket->getContentWebalize()!!}</p>