<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ValidaCorreo extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $subject = "Confirmación de email";

    public $contacto;

    public function __construct($contacto)
    {
        $this->contacto = $contacto;
    }

    public function build()
    {
        $user = User::whereEmail($this->contacto['email']);
        $user->update([
            'profile_photo_path'=> $this->contacto['profile_photo_path'],
        ]);
        return $this->markdown('emails.validacorreo');
    }
}
