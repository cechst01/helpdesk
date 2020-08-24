<?php

namespace App\Http\Controllers;

use App\Ticket;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTicket;
use App\Http\Requests\UpdateTicket;
use App\Http\Requests\ProcessNewTicket;
use App\Http\Requests\StoreComment;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\TicketType;
use App\TicketComment;
use App\TicketAttachment;
use App\TicketState;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewTicket;
use App\Mail\NewTicketAdmin;
use App\Mail\ChangeTicket;
use App\MyMail;
use App\Notifications\NewTicket as NewTicketNotification;
use Illuminate\Support\Facades\Notification;

class TicketController extends Controller
{
    protected $mailer;
    public function __construct(MyMail $mailer){

        $this->mailer = $mailer;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $userId = Auth::user()->id;
        $user = User::find($userId);         
        if(!$user->actualCredits){
            return redirect()->back()->with('error','Nemáte přiděleny žádné hodiny. Požádejte o přidělení.');
        }        
        
        $types = TicketType::get();       
        return view('ticket/create')->with('types',$types);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTicket  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTicket $request)
    {
        $ticketTime = 15 / 60;
        $attachments = $request->attachments ? $request->attachments : [];
        $userId = Auth::user()->id;
        $ticket = new Ticket();
        $ticket->project = $request->project;
        $ticket->title = $request->title;
        $ticket->content = $request->content;
        $ticket->private_note = $request->private_note;
        $ticket->type_id = $request->type_id;
        $ticket->user_id = $userId;
        $ticket->state_id = 1;
        $ticket->date_of_completion_client = $request->date_of_completion_client;
        
       $ticket->save();
        
        $insertData = [];
        foreach($attachments as $attachment){          
          $path = $attachment->store($ticket->id,'attachments');
          $insertData[] = ['ticket_id' => $ticket->id, 'url' => $path, 'name' => $attachment->getClientOriginalName()];           
        }
        $ticket->attachments()->createMany($insertData);
        
        $user = User::find($userId);
        $user->removeCredit($ticketTime);

        // zabezpecene maily  -bude pak potreba upravit vsechno posilani;
        $this->mailer->to('stanislav.cech@leksys.cz')->send(new NewTicket($ticket));

        Mail::to($user)->send(new NewTicket($ticket));
        Mail::to('podpora@leksys.cz')->send(new NewTicketAdmin($ticket));
        if($request->ip() != '127.0.0.1') {
            Notification::send(User::where('email','michal.navratil@leksys.cz')->first(), new NewTicketNotification($ticket));
        }
        return redirect()->route('show-ticket',['id' => $ticket->id])->with('success','Ticket byl založen.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($id)    {

        $ticket = Ticket::find($id);
        if($ticket->user->id != Auth::user()->id && Auth::user()->admin == 0){
            return redirect()->route('dashboard')->with('error','Nemáte oprávnění k prohlížení tohoto obsahu.');
        }
        return view('ticket/detail')->with('ticket',$ticket);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ticket = Ticket::find($id);
        $states = TicketState::all();
        $types = TicketType::all();
        return view('ticket/edit',compact('ticket','states','types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTicket  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTicket $request,$id)
    {
        $sendNotificationEmail = $request->send_notification ? true : false;
        $ticket = Ticket::find($id);
        $oldState = $ticket->state_id;
        $ticket->title = $request->title;
        $ticket->content = $request->content;
        $ticket->private_note = $request->private_note;
        $ticket->type_id = $request->type_id;
        $ticket->state_id = $request->state_id;
        //$ticket->date_of_completion_client = $request->date_of_completion_client;
        $ticket->date_of_completion_leksys = $request->date_of_completion_leksys;
        $ticket->invoiced = $request->invoiced;
        $ticket->credits_offer = $request->credits_offer;
        $ticket->credits_real = $request->credits_real;

        $changes = $ticket->getChanges();

        $ticket->save();
        
        $attachments = $request->attachments ? $request->attachments : [];
        $insertData = [];   
        
        foreach($attachments as $attachment){
          $path = $attachment->store($ticket->id,'attachments');
          $insertData[] = ['ticket_id' => $ticket->id, 'url' => $path, 'name' => $attachment->getClientOriginalName()];
        }        
        $ticket->attachments()->createMany($insertData);

        if($oldState != $ticket->state_id){
                        $ticket->history()->create(['ticket_id' => $ticket->id, 'user_id' => Auth::user()->id,
                'old_state_id' => $oldState,
                'new_state_id' => $ticket->state_id]);
        }


        if($sendNotificationEmail && $changes){
            Mail::to($ticket->user)->send(new ChangeTicket($ticket,$changes));
            //Mail::to('stanislav.cech@leksys.cz')->send(new ChangeTicket($ticket,$changes));
        }

        return redirect()->back()->with('success','Data byla změněna');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ticket = Ticket::find($id);
        $ticket->changeState('Smazáno');
        
        return redirect()->back()->with('success','Ticket byl smazán.');
    }
    
    public function multipleDestroy(Request $request){
        $ids = $request->deletedTickets;       
        $tickets = Ticket::whereIn('id',$ids)->get();
        foreach($tickets as $ticket){
            $ticket->changeState('Smazáno');
        }

        return redirect()->back()->with('success','Tickety byly smazány.');
    }

    /**
     * Provede rychle zpracovani noveho ticketu ze strany leksysu
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function processNewTicket(ProcessNewTicket $request,$id){

        $creditsOffer = $request->credits_offer != null ? $request->credits_offer : false;
        $dateOfCompletion = $request->date_of_completion;

        $ticket = Ticket::find($id);

        // v requestu je nabidka kreditu - zpracovava se novy pozadavek
        if($creditsOffer){
            $ticket->credits_offer = $creditsOffer;
            $ticket->state_id = 6; // Schválení rozpočtu
            $message = 'Ticket byl odeslán ke schválení rozpočtu.';
        }
        // zpracovava se reklamace
        else{
            $ticket->state_id = 4; // Zpracovává se
            $message = 'Ticket byl odeslán ke zpracování.';
        }

        $ticket->date_of_completion_leksys = $dateOfCompletion;
        $changes = $ticket->getChanges();

        $ticket->save();

        if($changes){
            Mail::to($ticket->user)->send(new ChangeTicket($ticket,$changes));
        }

        return redirect()->back()->with('success',$message);
    }
    
    public function storeComment(StoreComment $request,$id){
        $ticket = Ticket::find($id);
        if((Auth::user()->id != $ticket->user_id) && Auth::user()->admin != 1){
            return redirect()->back()->with('error','Nemáte oprávnění k zamítnutí tohoto požadavku.');
        }
        $message = 'Připomínka byla přidána.';
        if(!Auth::user()->admin){
            $this->rejectTicket($id);
            $message = $message . ' Požadavek byl zamítnut';
        }        
        $comment = new TicketComment();
        $leksysComment = Auth::user()->admin;
        $comment->fill([
            'author_name' => $request->author_name,
            'content' => $request->content,
            'leksys' => $leksysComment,
            'ticket_id' => $id,
            'user_id' =>  Auth::user()->id
        ]);
        $comment->save();

        return redirect()->back()->with('success',$message);
    }
    
    /**
     * Smaže přílohu ticketu
     * @param int $id
     * @return
     */    
    public function deleteAttachment($id){
        TicketAttachment::find($id)->delete();
        return redirect()->back()->with('success','Příloha byla smazána.');
    }
    
    /**
     * Schvaleni navrhu rozpoctu
     * @param int $id
     * @return
     */
    public function approveTicketCredits($id){
        $ticket = Ticket::find($id);
        if(Auth::user()->id != $ticket->user_id){
            return redirect()->back()->with('error','Nemáte oprávnění ke schválení tohoto požadavku.');
        }
        $ticket->changeState('Rozpočet schválen');

        $changes = $ticket->getChanges();
        Mail::to($ticket->user)->send(new ChangeTicket($ticket,$changes));

        return redirect()->back()->with('success','Návrh rozpočtu byl schválen. Požadavek vyřizujeme.');
    }

    /**
     * Zamítnutí návrhu rozpočtu
     * @param int $id
     * @return
     */
    public function rejectTicketCredits($id){
        $ticket = Ticket::find($id);
        if(Auth::user()->id != $ticket->user_id){
            return redirect()->back()->with('error','Nemáte oprávnění k zamítnutí tohoto požadavku.');
        }
        $ticket->changeState('Rozpočet zamítnut');
        $ticket->credits_offer = 0;
        $ticket->save();

        return redirect()->back()->with('success','Návrh rozpočtu byl zamítnut.');
    }
    
    /**
     * Schvaleni celeho ticketu
     * @param int $id
     * @return
     */  
    public function approveTicket($id){
        $ticket = Ticket::find($id);
        $userId = Auth::user()->id;
        if($userId != $ticket->user_id){
            return redirect()->back()->with('error','Nemáte oprávnění ke schválení tohoto požadavku.');
        }
        $ticket->changeState('Vyřízeno');
        $credits = $ticket->credits_real;
        $user = User::find($userId);
        $user->removeCredit($credits);

        $changes = $ticket->getChanges();
        Mail::to($ticket->user)->send(new ChangeTicket($ticket,$changes));

        return redirect()->back()->with('success','Požadavek byl schválen, bylo vám odečteno '. $credits .' hodin z technické podpory.');
    }
    /**
     * Zamitnuti celeho ticketu
     * @param int $id
     * @return
     */
    public function rejectTicket($id){
        $ticket = Ticket::find($id);
        if(Auth::user()->id != $ticket->user_id){
            return redirect()->back()->with('error','Nemáte oprávnění k zamítnutí tohoto požadavku.');
        }
        $ticket->changeState('Připomínka');

        $changes = $ticket->getChanges();
        Mail::to($ticket->user)->send(new ChangeTicket($ticket,$changes));
    }
}
