<?php

namespace App\Mail;

use App\Models\Tickets;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMailTicket extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Tickets $ticket,$png)
    {
        $this->event = $ticket->event;
        $this->ticket = $ticket;
        $this->png = $png;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.ticket-email',[
            'ticket'=>$this->ticket,
            'event'=>$this->event,
            'png'=>$this->png,
        ])
        ->subject('Compra Confirmada')
        ->from('naoresponda@itaingressos.fun',"ItaIngressos");
    }
}
