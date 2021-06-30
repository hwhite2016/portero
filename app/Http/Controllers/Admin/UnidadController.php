<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Unidad;
use App\Models\Bloque;
use App\Models\Parqueadero;
use App\Models\TipoUnidad;
use App\Models\ClaseUnidad;
use App\Models\Residente;
use App\Models\Vehiculo;
use App\Models\Mascota;

class UnidadController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('can:admin.unidads.index')->only('index');
        $this->middleware('can:admin.unidads.create')->only('create', 'store');
        $this->middleware('can:admin.unidads.edit')->only('edit', 'update');
        $this->middleware('can:admin.unidads.destroy')->only('destroy');
    }

    public function index()
    {
        $unidads = Unidad::leftjoin("residentes","residentes.unidadid", "=", "unidads.id")
        ->leftjoin("clase_unidads", "clase_unidads.id", "=", "unidads.claseunidadid")
        ->join("bloques","bloques.id", "=", "unidads.bloqueid")
        ->join("conjuntos","conjuntos.id", "=", "bloques.conjuntoid")
        ->select(Unidad::raw('count(residentes.id) as residente_count, unidads.id, unidads.bloqueid, conjuntonombre, bloques.bloquenombre, unidads.claseunidadid, clase_unidads.claseunidadnombre, clase_unidads.claseunidaddescripcion, unidadnombre'))
        ->whereIn('bloques.conjuntoid', session('dependencias'))
        ->groupBy('unidads.id', 'unidads.bloqueid', 'conjuntonombre', 'bloques.bloquenombre', 'unidads.claseunidadid', 'clase_unidads.claseunidadnombre', 'clase_unidads.claseunidaddescripcion', 'unidadnombre')
        ->orderBy('unidadnombre', 'DESC')
        ->get();
        return view('admin.unidad.index')->with('unidads', $unidads);
    }

    public function create()
    {
        $bloques = Bloque::whereIn('conjuntoid', session('dependencias'))->pluck('bloquenombre', 'id');
        $parqueaderos = Parqueadero::whereIn('conjuntoid', session('dependencias'))->pluck('parqueaderonumero', 'id');
        $tipo_unidads = TipoUnidad::all()->pluck('tipounidadnombre', 'tipounidadnombre');
        $clase_unidads = ClaseUnidad::select(
            DB::raw("CONCAT(claseunidadnombre,' (',claseunidaddescripcion,')') AS clasenombre"),'id')
            ->whereIn('conjuntoid', session('dependencias'))
            ->orderBy('id', 'DESC')
            ->pluck('clasenombre', 'id');

            return view('admin.unidad.create', compact('bloques','tipo_unidads','clase_unidads','parqueaderos'));    }

    public function store(Request $request)
    {
         $request->validate([
            'bloqueid'=>'required',
            'unidadnombre'=>'required',
            'claseunidadid'=>'required',
            'unidadnombre' => 'unique:unidads,unidadnombre,NULL,id,bloqueid,' . $request->get('bloqueid')
        ]);
        $unidad = Unidad::create([
            'bloqueid'=>$request->get('bloqueid'),
            'unidadnombre'=>$request->get('tipounidadid').' '.$request->get('unidadnombre'),
            'claseunidadid'=>$request->get('claseunidadid')
        ]);

        $unidad->parqueaderos()->sync($request->parqueaderos);
        return redirect()->route('admin.unidads.edit', $unidad->id)->with('info','La unidad fue agregada de forma exitosa');

    }

    public function show($id)
    {
        $unidads = Unidad::leftjoin("residentes","residentes.unidadid", "=", "unidads.id")
        ->leftjoin("clase_unidads", "clase_unidads.id", "=", "unidads.claseunidadid")
        ->join("bloques","bloques.id", "=", "unidads.bloqueid")
        ->join("conjuntos","conjuntos.id", "=", "bloques.conjuntoid")
        ->select(Unidad::raw('count(residentes.id) as residente_count, unidads.id, unidads.bloqueid, conjuntonombre, bloques.bloquenombre, unidads.claseunidadid, clase_unidads.claseunidadnombre, clase_unidads.claseunidaddescripcion, unidadnombre'))
        ->where('unidads.bloqueid', '=', $id)
        ->whereIn('bloques.conjuntoid', session('dependencias'))
        ->groupBy('unidads.id', 'unidads.bloqueid','conjuntonombre', 'bloques.bloquenombre', 'unidads.claseunidadid', 'clase_unidads.claseunidadnombre', 'clase_unidads.claseunidaddescripcion', 'unidadnombre')
        ->orderBy('unidadnombre', 'DESC')
        ->get();

        return view('admin.unidad.index')->with('unidads', $unidads);

    }

    public function edit($id)
    {
        $unidad = Unidad::find($id);
        $bloques = Bloque::whereIn('conjuntoid', session('dependencias'))->pluck('bloquenombre', 'id');
        $parqueaderos = Parqueadero::whereIn('conjuntoid', session('dependencias'))->pluck('parqueaderonumero', 'id');
        $tipo_unidads = TipoUnidad::all()->pluck('tipounidadnombre', 'tipounidadnombre');
        $clase_unidads = ClaseUnidad::select(
            DB::raw("CONCAT(claseunidadnombre,' (',claseunidaddescripcion,')') AS clasenombre"),'id')
            ->whereIn('conjuntoid', session('dependencias'))
            ->pluck('clasenombre', 'id');
        $residentes = Residente::join('tipo_residentes', 'tipo_residentes.id', '=', 'tiporesidenteid')
        ->join('personas', 'personas.id', '=', 'personaid')
        ->join('unidads', 'unidads.id', '=', 'unidadid')
        ->join('relations', 'relations.id', '=', 'relationid')
        ->select(Residente::raw('residentes.id, personanombre, tiporesidentenombre, personacelular, relationname' ))
        ->where('unidads.id', $id)
        ->get();
        $vehiculos = Vehiculo::join('tipo_vehiculos', 'tipo_vehiculos.id', '=', 'tipovehiculoid')
        ->join('unidads', 'unidads.id', '=', 'unidadid')
        ->select(Vehiculo::raw('vehiculos.id, tipovehiculonombre, vehiculomarca, vehiculoplaca' ))
        ->where('unidads.id', $id)
        ->get();
        $mascotas = Mascota::join('tipo_mascotas', 'tipo_mascotas.id', '=', 'tipomascotaid')
        ->join('unidads', 'unidads.id', '=', 'unidadid')
        ->select(mascota::raw('mascotas.id, tipomascotanombre, mascotaraza, mascotaedad' ))
        ->where('unidads.id', $id)
        ->get();
        $act_residentes = 'active'; $act_vehiculos = ''; $act_mascotas = '';
        return view('admin.unidad.edit', compact('unidad', 'bloques','tipo_unidads','clase_unidads','parqueaderos','residentes','vehiculos','mascotas', 'act_residentes', 'act_vehiculos', 'act_mascotas'));

    }

    public function update(Request $request, Unidad $unidad)
    {
        $validar_update = $unidad->id > 0 ? $unidad->id : "NULL";
        $request->validate([
            'bloqueid'=>'required',
            'unidadnombre'=>'required',
            'claseunidadid'=>'required',
            'unidadnombre' => 'unique:unidads,unidadnombre,'.$validar_update.',id,bloqueid,' . $request->get('bloqueid')
        ]);
        $unidad->update($request->all());

        $unidad->parqueaderos()->sync($request->parqueaderos);
        return redirect()->route('admin.unidads.edit', $unidad->id )->with('info','La unidad fue actualizada de forma exitosa');
    }

    public function destroy($id)
    {
        $unidad = Unidad::find($id);
        if(count($unidad->residentes)){
            return redirect()->route('admin.unidads.show', $unidad->bloqueid)->with('error','La unidad no se puede eliminar ya que contiene residentes');
        }
        if(count($unidad->vehiculos)){
            return redirect()->route('admin.unidads.show', $unidad->bloqueid)->with('error','La unidad no se puede eliminar ya que contiene vehiculos');
        }
        if(count($unidad->mascotas)){
            return redirect()->route('admin.unidads.show', $unidad->bloqueid)->with('error','La unidad no se puede eliminar ya que contiene mascotas');
        }
        $unidad->delete();
        return redirect()->route('admin.unidads.show', $unidad->bloqueid)->with('info','La unidad fue eliminada exitosamente');
    }
}
