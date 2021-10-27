<?php

namespace App\Listeners;

use App\Models\Barrio;
use App\Models\Ciudad;
use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;
use App\Models\Conjunto;
use App\Models\Pais;
use App\Models\Registro;
use App\Models\TipoDocumento;
use App\Models\TipoPropietario;
use App\Models\User;

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

            if(!$personaid) {
                return redirect()->route('registros.create');
            }else{
                $user = User::find(Auth::user()->id);
                if ($user->hasRole('_pendiente')){
                    $registro = Registro::where('personaid', $personaid)->where('registroestado', 0)->first();
                    return redirect()->route('registros.edit', $registro->id);
                }
            }

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
