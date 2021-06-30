<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;

    //Relacion muchos a muchos
    public function conjuntos(){
    	return $this->belongsToMany(Conjunto::class, 'persona_conjuntos');
    }

    public function visitantes(){
        return $this->hasOne(Visitante::class, 'personaid');
    }

       protected $fillable = ['tipodocumentoid', 'personadocumento', 'personanombre', 'personafechanacimiento', 'personacelular', 'personacorreo'];
}
