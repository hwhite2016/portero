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

    public function personas(){
    	return $this->belongsToMany(Persona::class, 'persona_conjuntos');
    }

    //use SoftDeletes; //Implementamos

    //protected $dates = ['deleted_at']; //Registramos la nueva columna

    protected $guarded = [];
    //protected $fillable = ['barrioid', 'conjuntonit', 'conjuntonombre', 'conjuntodireccion', 'conjuntologo', 'conjuntokey', 'conjuntocelular', 'conjuntotelefono', 'conjuntoestado'];
}
