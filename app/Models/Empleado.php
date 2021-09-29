<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    use HasFactory;

    //Relacion uno a muchos (inversa)
    public function conjunto(){
        return $this->belongsTo(Conjunto::class, 'conjuntoid');
    }

    protected $fillable = ['conjuntoid', 'personaid', 'organo_id','cargo_id', 'role_id', 'empleadocorreo', 'empleadoestado'];
}
