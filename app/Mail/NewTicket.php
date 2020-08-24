<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Ticket;

class NewTicket extends Mailable
{
    use Queueable, SerializesModels;


    public $ticket;
    /**
     * Create a new message instance.
     * @param \Ticket
     * @return void
     */
    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("LEKSYS | HELPDESK - Založení ticketu č. {$this->ticket->id}")
                    ->view('mail/newTicket');
    }
}
