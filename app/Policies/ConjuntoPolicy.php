<?php

namespace App\Policies;

use App\Models\Conjunto;
use App\Models\Persona;
use App\Models\PersonaConjunto;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ConjuntoPolicy
{
    use HandlesAuthorization;

    public function administrador(User $user, Conjunto $conjunto){
        if(PersonaConjunto::wherePersona_id($user->personaid)->whereConjunto_id($conjunto->id)->whereIn('conjunto_id', session('dependencias'))->exists()){
            return true;
        }else{
            return false;
        }

    }
}
