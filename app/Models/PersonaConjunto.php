<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonaConjunto extends Model
{
    use HasFactory;

    //Relacion uno a muchos (inversa)
    public function conjunto(){
        return $this->belongsTo(Conjunto::class, 'conjunto_id');
    }

    public function persona(){
        return $this->belongsTo(Persona::class, 'persona_id');
    }
}
