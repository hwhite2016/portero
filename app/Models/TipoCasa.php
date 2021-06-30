<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

class TipoCasa extends Model
{
    use HasFactory;

    //Relacion uno a muchos
    public function casas(){
    	return $this->hasMany('App\Models\Casa');
    }

    protected $fillable = ['tipocasanombre'];
}
