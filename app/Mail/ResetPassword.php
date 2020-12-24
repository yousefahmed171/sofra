<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPassword extends Mailable
{
    use Queueable, SerializesModels;

    //private $restaurant;

    //private $client;

    private $sofra;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($sofra)
    {
        //
        // $this->restaurant   = $restaurant;
        // $this->client       = $client;

        $this->sofra = $sofra;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //return $this->view('view.name');
        //return $this->markdown('restaurant.emails.auth.reset', ['restaurant' => $this->restaurant]);

        //return $this->markdown('client.emails.auth.reset', ['client' => $this->client]);

        return $this->markdown('emails.auth.reset', ['sofra' => $this->sofra]);
    }
}
