<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Ticket;

class ChangeTicket extends Mailable
{
    use Queueable, SerializesModels;


    public $ticket, $changes;
    /**
     * Create a new message instance.
     * @param \Ticket $ticket
     * @param Array $changes
     * @return void
     */
    public function __construct(Ticket $ticket, Array $changes)
    {
        $this->ticket = $ticket;
        $this->changes = $changes;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
                ->subject("LEKSYS | HELPDESK - Změna ticketu č. {$this->ticket->id}")
                ->view('mail/changeTicket');
    }
}
