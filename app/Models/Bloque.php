<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

class Bloque extends Model
{
    use HasFactory;

    //Relacion uno a muchos
    public function unidads(){
        return $this->hasMany(Unidad::class, 'bloqueid');
    }

    //Relacion uno a muchos (inversa)
    public function conjunto(){
    	return $this->belongsTo(Conjunto::class);
    }

    //Relacion uno a muchos (inversa)
    public function tipobloque(){
        return $this->belongsTo(TipoBloque::class);
    }

        protected $fillable = ['conjuntoid', 'tipobloqueid', 'bloquenombre', 'bloqueniveles'];
}
