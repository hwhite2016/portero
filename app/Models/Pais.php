<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Pais extends Model
{
    use HasFactory;

    //Relacion uno a muchos
    public function ciudads(){
    	return $this->hasMany('App\Models\Ciudad');
    }

    //use SoftDeletes; //Implementamos

    //protected $dates = ['deleted_at']; //Registramos la nueva columna

    protected $fillable = ['paisnombre', 'paiscodigo', 'paisabreviatura', 'paisbandera'];

    protected $guarded = [];
}
