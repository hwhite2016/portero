<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PqrOrgano extends Model
{
    use HasFactory;

    //Relacion uno a muchos (inversa)
    public function organo(){
        return $this->belongsTo(Organo::class, 'organo_id');
    }

    public function pqr(){
        return $this->belongsTo(Pqr::class, 'pqr_id');
    }
}
