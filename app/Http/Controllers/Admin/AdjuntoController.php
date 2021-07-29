<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Adjunto;
use Illuminate\Http\Request;

class AdjuntoController extends Controller
{
    public function index($id){
        $adjuntos = Adjunto::join('users', 'users.id', 'adjuntos.userid')
            ->select('adjuntos.*', 'users.name')
            ->where('adjuntos.pqrid', $id)
            ->orderBy('adjuntos.created_at')
            ->get();
    }
}
