<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;
use App\Models\User;
use App\Models\Residente;
use App\Notifications\EntregaNotification;

class EntregaListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        User::join('residentes','residentes.personaid','=','users.personaid')
            ->where('residentes.id', '=', $event->entrega->entregadestinatario)
            ->select(Residente::raw('users.id'))
            ->each(function(User $user) use ($event){
                //$user->notify(new EntregaNotification($entrega));
                Notification::send($user, new EntregaNotification($event->entrega));
            });

            //->except($event->post->user_id)

    }
}
