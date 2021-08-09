<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Entrega;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SeguimientoController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('can:admin.seguimiento.index')->only('index');
        $this->middleware('can:admin.seguimiento.edit')->only('edit', 'update');

    }

    public function index()
    {

        $entregas = Entrega::join("unidads","unidads.id", "=", "entregas.unidadid")
             ->join('bloques','bloques.id','=','unidads.bloqueid')
             ->join('conjuntos','conjuntos.id','=','bloques.conjuntoid')
             ->join('tipo_entregas','tipo_entregas.id','=','entregas.tipoentregaid')
             ->join('residentes','residentes.id','=','entregas.entregadestinatario')
             ->join('personas','personas.id','=','residentes.personaid')
             ->select(Entrega::raw('entregas.id, conjuntonombre, bloquenombre, unidadnombre, tipoentregaid, tipoentreganombre, entregaempresa, entregareceptor, personanombre, entregaobservacion, entregafechaentrega, entregaestado,entregas.created_at'))
             ->where('entregas.entregaestado', 0)
             ->where('residentes.personaid', Auth::user()->personaid)
             ->whereIn('conjuntos.id', session('dependencias'))
             ->orderBy('entregas.created_at', 'DESC')
             ->get();
             return view('admin.entrega.seguimiento')->with('entregas', $entregas);
    }

    public function show($id)
    {

        $entregas = Entrega::join("unidads","unidads.id", "=", "entregas.unidadid")
        ->join('bloques','bloques.id','=','unidads.bloqueid')
        ->join('conjuntos','conjuntos.id','=','bloques.conjuntoid')
        ->join('tipo_entregas','tipo_entregas.id','=','entregas.tipoentregaid')
        ->join('residentes','residentes.id','=','entregas.entregadestinatario')
        ->join('personas','personas.id','=','residentes.personaid')
        ->select(Entrega::raw('entregas.id, conjuntonombre, bloquenombre, unidadnombre, tipoentregaid, tipoentreganombre, entregaempresa, entregareceptor, personanombre, entregaobservacion, entregafechaentrega,entregaestado,entregas.created_at'))
        ->where('entregas.entregaestado', $id, 0)
        ->whereIn('conjuntos.id', session('dependencias'))
        ->orderBy('entregas.created_at', 'DESC')
        ->get();
        return view('admin.entrega.seguimiento')->with('entregas', $entregas);
    }

    public function update(Entrega $entrega)
    {

        $entrega->update(['entregaestado'=> 1]);
        return redirect()->route('admin.seguimiento.index')->with('info','La confirmación de la entrega fue exitosa');
    }

}
