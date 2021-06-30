<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

class Barrio extends Model
{
    use HasFactory;

    //Relacion uno a muchos
    public function conjuntos(){
    	return $this->hasMany('App\Models\Conjunto');
    }

    //Relacion uno a muchos (inversa)
    public function ciudad(){
    	return $this->belongsTo('App\Models\Ciudad');
    }

    //use SoftDeletes; //Implementamos

    //protected $dates = ['deleted_at']; //Registramos la nueva columna

    protected $fillable = ['ciudadid', 'barrionombre', 'barrioestrato'];
}
