<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

class Conjunto extends Model
{
    use HasFactory;

    //Relacion uno a muchos
    public function bloques(){
    	return $this->hasMany('App\Models\Bloque');
    }

    //Relacion uno a muchos (inversa)
    public function barrio(){
    	return $this->belongsTo('App\Models\Barrio');
    }

    public function users(){
    	return $this->belongsToMany(User::class, 'users_conjuntos');
    }

    //use SoftDeletes; //Implementamos

    //protected $dates = ['deleted_at']; //Registramos la nueva columna

    protected $fillable = ['barrioid', 'conjuntonombre', 'conjuntodireccion', 'conjuntologo', 'conjuntocorreo', 'conjuntocelular', 'conjuntotelefono', 'conjuntoestado'];
}
