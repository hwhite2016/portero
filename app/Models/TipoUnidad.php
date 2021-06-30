<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoUnidad extends Model
{
    use HasFactory;

    //Relacion uno a muchos
    public function unidads(){
        return $this->hasMany(Unidad::class);
    }

    protected $fillable = ['tipounidadnombre'];
}
