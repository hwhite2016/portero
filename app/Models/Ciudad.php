<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

class Ciudad extends Model
{
    use HasFactory;

    //Relacion uno a muchos
	public function barrios(){
    	return $this->hasMany(Barrio::class);
    }

    //Relacion uno a muchos (inversa)
    public function pais(){
    	return $this->belongsTo(Pais::class, 'paisid');
    }

    //use SoftDeletes; //Implementamos

    //protected $dates = ['deleted_at']; //Registramos la nueva columna

    protected $fillable = ['paisid', 'ciudadnombre', 'ciudadcodigo', 'ciudadabreviatura'];


}
