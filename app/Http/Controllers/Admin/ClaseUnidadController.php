<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ClaseUnidad;
use App\Models\Conjunto;

class ClaseUnidadController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('can:admin.clase_unidads.index')->only('index');
        $this->middleware('can:admin.clase_unidads.create')->only('create', 'store');
        $this->middleware('can:admin.clase_unidads.edit')->only('edit', 'update');
        $this->middleware('can:admin.clase_unidads.destroy')->only('destroy');
    }

    public function index()
    {
        $clase_unidads = ClaseUnidad::join("conjuntos","conjuntos.id", "=", "clase_unidads.conjuntoid")
             ->select(ClaseUnidad::raw('clase_unidads.id, clase_unidads.conjuntoid, conjuntonombre, claseunidadnombre, claseunidaddescripcion, claseunidadcuota'))
             ->whereIn('conjuntos.id', session('dependencias'))
             ->groupBy('clase_unidads.id', 'clase_unidads.conjuntoid', 'conjuntonombre', 'claseunidadnombre', 'claseunidaddescripcion', 'claseunidadcuota')
             ->orderBy('claseunidadnombre', 'ASC')
             ->get();

        return view('admin.clase_unidad.index')->with('clase_unidads', $clase_unidads);
    }

    public function create()
    {
        $conjuntos = Conjunto::whereIn('conjuntos.id', session('dependencias'))->pluck('conjuntonombre', 'id');
        return view('admin.clase_unidad.create')->with('conjuntos',$conjuntos);
    }

    public function getModal()
    {
        $conjuntos = Conjunto::whereIn('conjuntos.id', session('dependencias'))->pluck('conjuntonombre', 'id');
        return view('admin.clase_unidad.createModal')->with('conjuntos',$conjuntos);
    }

    public function store(Request $request)
    {
        $request->validate([
            'conjuntoid'=>'required',
            'claseunidadnombre'=>'required',
            'claseunidadnombre' => 'unique:clase_unidads,claseunidadnombre,NULL,id,conjuntoid,' . $request->get('conjuntoid')
        ]);

        $cuota = str_replace(".", "", $request->get('claseunidadcuota'));
        $clase_unidads = ClaseUnidad::create([
            'conjuntoid'=>$request->get('conjuntoid'),
            'claseunidadnombre'=>$request->get('claseunidadnombre'),
            'claseunidaddescripcion'=>$request->get('claseunidaddescripcion'),
            'claseunidadcuota'=>$cuota,
        ]);
        if($request->get('modal')) {
            return redirect()->route('admin.unidads.create');
        }else{
            return redirect()->route('admin.clase_unidads.show', $clase_unidads->conjuntoid)->with('info','El tipo de unidad fue agregado de forma exitosa');
        }
    }

    public function show($id)
    {
        $clase_unidads = ClaseUnidad::join("conjuntos","conjuntos.id", "=", "clase_unidads.conjuntoid")
             ->select(ClaseUnidad::raw('clase_unidads.id, clase_unidads.conjuntoid, conjuntonombre, claseunidadnombre, claseunidaddescripcion, claseunidadcuota'))
             ->where('clase_unidads.conjuntoid', '=', $id)
             ->whereIn('conjuntos.id', session('dependencias'))
             ->groupBy('clase_unidads.id', 'clase_unidads.conjuntoid', 'conjuntonombre', 'claseunidadnombre', 'claseunidaddescripcion', 'claseunidadcuota')
             ->orderBy('claseunidadnombre', 'ASC')
             ->get();

        return view('admin.clase_unidad.index')->with('clase_unidads', $clase_unidads);
    }

    public function edit($id)
    {
        $clase_unidad = ClaseUnidad::find($id);
        $conjuntos = Conjunto::whereIn('conjuntos.id', session('dependencias'))->pluck('conjuntonombre', 'id');
        return view('admin.clase_unidad.edit')->with('clase_unidad',$clase_unidad)->with('conjuntos',$conjuntos);
    }

    public function update(Request $request, ClaseUnidad $clase_unidad)
    {
        $validar_update = $clase_unidad->id > 0 ? $clase_unidad->id : "NULL";

        $request->validate([
            'conjuntoid'=>'required',
            'claseunidadnombre'=>'required',
            'claseunidadnombre' => 'unique:clase_unidads,claseunidadnombre,' . $validar_update . ',id,conjuntoid,' . $request->get('conjuntoid')
        ]);
        $cuota = str_replace(".", "", $request->get('claseunidadcuota'));
        $clase_unidad->update([
            'conjuntoid'=>$request->get('conjuntoid'),
            'claseunidadnombre'=>$request->get('claseunidadnombre'),
            'claseunidaddescripcion'=>$request->get('claseunidaddescripcion'),
            'claseunidadcuota'=>$cuota,
        ]);
        return redirect()->route('admin.clase_unidads.show', $clase_unidad->conjuntoid)->with('info','El tipo de unidad fue actualizado de forma exitosa');
    }

    public function destroy($id)
    {
        $clase_unidad = ClaseUnidad::find($id);
        $clase_unidad->delete();
        return redirect()->route('admin.clase_unidads.show', $clase_unidad->conjuntoid)->with('info','El tipo de unidad fue eliminado exitosamente');
    }
}
