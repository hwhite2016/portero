<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Visitante extends Model
{
    use HasFactory;


    //Relacion uno a muchos (inversa)
    public function unidad(){
        return $this->belongsTo(Unidad::class, 'unidadid');
    }

    public function persona(){
        return $this->belongsTo(Persona::class, 'personaid');
    }

    public function parqueadero(){
        return  $this->hasMany (Parqueadero::class, 'parqueaderoid');
    }

    use SoftDeletes;
    protected $dates = ['deleted_at']; //Registramos la nueva columna

    protected $guarded = [];

}
