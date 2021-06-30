<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventCalendar extends Model
{
    use HasFactory;

    //Relacion uno a muchos (inversa)
    public function zona(){
        return $this->belongsTo(Zona::class, 'zonaid');
    }

    protected $guarded = [];
}
