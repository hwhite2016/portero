<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClaseUnidad extends Model
{
    use HasFactory;

    //Relacion uno a muchos
    public function unidads(){
        return $this->hasMany(Unidad::class);
    }

    //Relacion uno a muchos (inversa)
    public function conjunto(){
        return $this->belongsTo(Conjunto::class, 'conjuntoid');
    }

    protected $fillable = ['conjuntoid', 'claseunidadnombre', 'claseunidaddescripcion', 'claseunidadcuota'];
}
