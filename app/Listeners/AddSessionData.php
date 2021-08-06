<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;
use App\Models\Conjunto;

class AddSessionData
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
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
            $personaid = Auth::user()->personaid;
            $dependencias = Conjunto::select(['conjuntos.id'])
            ->join('persona_conjuntos', 'conjuntos.id', '=', 'persona_conjuntos.conjunto_id')
            ->whereRaw('persona_conjuntos.persona_id = ' . $personaid)
            ->get();

            if(count($dependencias) >= 1) {
                foreach ($dependencias as $dependencia){
                    $dep[] = $dependencia->id;
                }
                //session(['dependencias'=>$dep]);
            }
    }
}
