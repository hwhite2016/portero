<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ComunicadoMailable extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $subject;

    public $contacto;

    public function __construct($contacto)
    {
        $this->contacto = $contacto;
        $this->subject = $contacto['subject'];
    }

    public function build()
    {
        if($this->contacto['ruta']){
            //return $this->view('emails.comunicado')->attach($this->contacto['ruta']);
            return $this->markdown('emails.comunicado')->attach($this->contacto['ruta']);
        }else{
            //return $this->view('emails.comunicado');
            return $this->markdown('emails.comunicado');
        }
    }
}
