<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unidad extends Model
{
    use HasFactory;

    //Relacion uno a muchos
    public function residentes(){
        return $this->hasMany(Residente::class, 'unidadid');
    }
    public function vehiculos(){
        return $this->hasMany(Vehiculo::class, 'unidadid');
    }
    public function mascotas(){
        return $this->hasMany(Mascota::class, 'unidadid');
    }

    //Relacion muchos a muchos
    public function parqueaderos(){
    	return $this->belongsToMany(Parqueadero::class, 'unidads_parqueaderos');
    }

    //Relacion uno a muchos (inversa)
    public function bloque(){
        return $this->belongsTo(Bloque::class, 'bloqueid');
    }

    protected $fillable = ['bloqueid', 'claseunidadid', 'unidadnombre', 'propietarioid'];
}
