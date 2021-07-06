<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entrega extends Model
{
    use HasFactory;

    //Relacion muchos a muchos
    public function residentes(){
    	return $this->belongsToMany(Residente::class, 'entrega_residentes');
    }

    //Relacion uno a muchos (inversa)
    public function unidad(){
        return $this->belongsTo(Unidad::class, 'unidadid');
    }

    protected $guarded = ['id'];


}
