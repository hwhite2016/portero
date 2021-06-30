<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnidadsParqueadero extends Model
{
    use HasFactory;

    //Relacion uno a muchos (inversa)
    public function parqueadero(){
        return $this->belongsTo(Parqueadero::class, 'parqueadero_id');
    }

    public function unidad(){
        return $this->belongsTo(Unidad::class, 'unidad_id');
    }
}
