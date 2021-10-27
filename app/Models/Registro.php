<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registro extends Model
{
    use HasFactory;

    //Relacion muchos a muchos
    public function parqueaderos(){
    	return $this->belongsToMany(Parqueadero::class, 'unidads_parqueaderos', 'unidad_id');
    }

    protected $guarded = [];
}
