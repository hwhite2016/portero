<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

class TipoBloque extends Model
{
    use HasFactory;

    //Relacion uno a muchos
    public function bloques(){
    	return $this->hasMany('App\Models\Bloque');
    }

    protected $fillable = ['tipobloquenombre'];
}
