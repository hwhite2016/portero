<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class usersConjunto extends Model
{
    use HasFactory;
    use HasRoles;

    //Relacion uno a muchos (inversa)
    public function conjunto(){
        return $this->belongsTo(Conjunto::class, 'conjunto_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
