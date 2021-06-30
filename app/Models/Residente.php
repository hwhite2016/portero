<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

class Residente extends Model
{
    use HasFactory;

    //Relacion uno a muchos (inversa)
    public function unidad(){
        return $this->belongsTo(Unidad::class, 'unidadid');
    }

    protected $fillable = ['unidadid', 'personaid', 'tiporesidenteid', 'relationid'];
}
