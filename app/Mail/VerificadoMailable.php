<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerificadoMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = "Bienvenido a Portero.com.co";

    public $contacto;

    public function __construct($contacto)
    {
        $this->contacto = $contacto;
    }

    public function build()
    {

        return $this->markdown('emails.apto_verificado');
    }
}
