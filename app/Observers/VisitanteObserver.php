<?php

namespace App\Observers;

use App\Models\Visitante;
use App\Models\Parqueadero;

class VisitanteObserver
{
    /**
     * Handle the Visitante "created" event.
     *
     * @param  \App\Models\Visitante  $visitante
     * @return void
     */
    public function created(Visitante $visitante)
    {
        //
    }

    /**
     * Handle the Visitante "updated" event.
     *
     * @param  \App\Models\Visitante  $visitante
     * @return void
     */
    public function updated(Visitante $visitante)
    {
         if($visitante->parqueaderoid){
            $parqueadero = Parqueadero::find($visitante->parqueaderoid);
            $parqueadero->update([
                'estadoparqueaderoid'=>2,
            ]);
         }
    }

    /**
     * Handle the Visitante "deleted" event.
     *
     * @param  \App\Models\Visitante  $visitante
     * @return void
     */
    public function deleted(Visitante $visitante)
    {
        if($visitante->parqueaderoid){
            $parqueadero = Parqueadero::find($visitante->parqueaderoid);
            $parqueadero->update([
                'estadoparqueaderoid'=>1,
            ]);
        }
    }

    /**
     * Handle the Visitante "restored" event.
     *
     * @param  \App\Models\Visitante  $visitante
     * @return void
     */
    public function restored(Visitante $visitante)
    {
        //

    }

    /**
     * Handle the Visitante "force deleted" event.
     *
     * @param  \App\Models\Visitante  $visitante
     * @return void
     */
    public function forceDeleted(Visitante $visitante)
    {
        //
    }
}
