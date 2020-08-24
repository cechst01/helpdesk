<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use App\Ticket;

class NewTicket extends Notification
{
    use Queueable;

    protected $ticket;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['slack'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }


    /**
     * Get the slack representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return @return \Illuminate\Notifications\Messages\SlackMessage
     */
    public function toSlack($notifiable){
        $ticket = $this->ticket;
        $url = route('show-ticket',['id' => $ticket->id]);
        return (new SlackMessage)
                    ->from($ticket->user->user_name . $ticket->user->company_name, ':ghost:')
                    ->success()
                    ->attachment(function ($attachment) use ($ticket, $url) {
                        $userName = $ticket->user->user_name . " ". "({$ticket->user->company_name})";
                        $attachment->title("Nový ticket č. {$ticket->id}", $url)
                            ->content("Uživatelem {$userName} byl založen nový ticket.")
                            ->fields([
                                'Projekt' => $ticket->project,
                                'Název' => $ticket->title,
                                'Vytvořeno' => $ticket->created_at,
                                'Požadovaný termín dodání' => $ticket->date_of_completion_client,
                                'Typ' => $ticket->type->name,
                                'Popis' => $ticket->content,
                            ]);
                    });


    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
