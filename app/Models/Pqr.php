<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pqr extends Model
{
    use HasFactory;

    //Relacion uno a muchos (inversa)
    public function tipopqr(){
        return $this->belongsTo(TipoPqr::class, 'tipopqrid');
    }

    //Relacion muchos a muchos
    public function organos(){
    	return $this->belongsToMany(Organo::class, 'pqr_organos');
    }

    protected $guarded = [];
}
