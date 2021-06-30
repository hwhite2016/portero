<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntregaResidente extends Model
{
    use HasFactory;

    //Relacion uno a muchos (inversa)
    public function residente(){
        return $this->belongsTo(Residente::class, 'residente_id');
    }

    public function entrega(){
        return $this->belongsTo(Entrega::class, 'entregaid_id');
    }
}
