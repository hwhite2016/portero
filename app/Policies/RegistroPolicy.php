<?php

namespace App\Policies;

use App\Models\Registro;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RegistroPolicy
{
    use HandlesAuthorization;

    public function pendiente(User $user, Registro $registro){
        if(Registro::wherePersonaid($user->personaid)->whereUnidadid($registro->unidadid)->exists()){
            return true;
        }else{
            return false;
        }

    }
}
