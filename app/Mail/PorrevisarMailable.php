<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PorrevisarMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = "Nuevo registro para su revisión";

    public $contacto;

    public function __construct($contacto)
    {
        $this->contacto = $contacto;
    }

    public function build()
    {

        return $this->markdown('emails.porrevisar');
    }
}
