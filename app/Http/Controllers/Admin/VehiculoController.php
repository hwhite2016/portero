<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vehiculo;
use App\Models\TipoVehiculo;
use App\Models\Conjunto;
use App\Models\Unidad;

class VehiculoController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('can:admin.vehiculos.index')->only('index');
        $this->middleware('can:admin.vehiculos.create')->only('create', 'store');
        $this->middleware('can:admin.vehiculos.edit')->only('edit', 'update');
        $this->middleware('can:admin.vehiculos.destroy')->only('destroy');
    }

    public function index()
    {

        $vehiculos = Vehiculo::join("unidads","unidads.id", "=", "vehiculos.unidadid")
             ->join('bloques','bloques.id','=','unidads.bloqueid')
             ->join('conjuntos','conjuntos.id','=','bloques.conjuntoid')
             ->join('tipo_vehiculos','tipo_vehiculos.id','=','vehiculos.tipovehiculoid')
             ->select(Vehiculo::raw('vehiculos.id, conjuntonombre, bloquenombre, unidadnombre, tipovehiculoid, tipovehiculonombre, vehiculomarca, vehiculoplaca'))
             ->whereIn('conjuntos.id', session('dependencias'))
             ->orderBy('unidadnombre', 'ASC')
             ->get();
             return view('admin.vehiculo.index')->with('vehiculos', $vehiculos);
    }

    public function create(Request $request)
    {
        $tipo_vehiculos = TipoVehiculo::all()->pluck('tipovehiculonombre', 'id');
        $conjuntos = Conjunto::whereIn('conjuntos.id', session('dependencias'))->pluck('conjuntonombre', 'id');

        $unidads = Unidad::join('bloques','bloques.id','=','unidads.bloqueid')
            ->select(
            Unidad::raw("CONCAT(bloquenombre,' - ',unidadnombre) AS unidad"),'unidads.id')
            ->whereIn('conjuntoid', session('dependencias'))
            ->orderBy('unidad','ASC')
            ->pluck('unidad', 'unidads.id');

        $unidads->prepend('Seleccione la unidad', '');

        return view('admin.vehiculo.create', compact('tipo_vehiculos', 'conjuntos', 'unidads'));
    }

    public function createModal(Request $request, $id)
    {
        $tipo_vehiculos = Tipovehiculo::all()->pluck('tipovehiculonombre', 'id');
        $conjuntos = Unidad::join('bloques','bloques.id','=','unidads.bloqueid')
            ->join('conjuntos','conjuntos.id','=','bloques.conjuntoid')
            ->select('conjuntonombre','conjuntos.id')
            ->where('unidads.id', '=', $id)
            ->pluck('conjuntonombre', 'id');

        $unidads = Unidad::join('bloques','bloques.id','=','unidads.bloqueid')
            ->select(
            Unidad::raw("CONCAT(bloquenombre,' - ',unidadnombre) AS unidad"),'unidads.id')
            ->where('unidads.id', '=', $id)
            ->whereIn('conjuntoid', session('dependencias'))
            ->orderBy('unidad','ASC')
            ->pluck('unidad', 'unidads.id');

        //$unidads->prepend('Seleccione la unidad', '');

        return view('admin.vehiculo.createModal', compact('tipo_vehiculos', 'conjuntos', 'unidads'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'conjuntoid'=>'required',
            'unidadid'=>'required',
            'vehiculoplaca' => 'unique:vehiculos'
        ]);

        Vehiculo::create([
            'unidadid'=>$request->get('unidadid'),
            'tipovehiculoid'=>$request->get('tipovehiculoid'),
            'vehiculoplaca'=>$request->get('vehiculoplaca'),
            'vehiculomarca'=>$request->get('vehiculomarca')
        ]);
        if(!$request->get('vehiculos'))
            return redirect()->route('admin.vehiculos.index')->with('info','El vehiculo fue agregado de forma exitosa');
        else
            return redirect()->route('admin.unidads.edit', $request->get('unidadid'))->with('info','El vehiculo fue agregado de forma exitosa');

    }

    public function show($id)
    {
        $vehiculos = Vehiculo::join("unidads","unidads.id", "=", "vehiculos.unidadid")
        ->join('bloques','bloques.id','=','unidads.bloqueid')
        ->join('conjuntos','conjuntos.id','=','bloques.conjuntoid')
        ->join('tipo_vehiculos','tipo_vehiculos.id','=','vehiculos.tipovehiculoid')
        ->select(Vehiculo::raw('vehiculos.id, conjuntonombre, bloquenombre, unidadnombre, tipovehiculoid, tipovehiculonombre, vehiculomarca, vehiculoplaca'))
        ->where('unidads.id', $id)
        ->whereIn('conjuntos.id', session('dependencias'))
        ->orderBy('unidadnombre', 'ASC')
        ->get();
        return view('admin.vehiculo.index')->with('vehiculos', $vehiculos);
    }

    public function edit($id)
    {
        $vehiculo = Vehiculo::find($id);
        $tipo_vehiculos = TipoVehiculo::all()->pluck('tipovehiculonombre', 'id');
        $conjuntos = Conjunto::whereIn('conjuntos.id', session('dependencias'))->pluck('conjuntonombre', 'id');
        $unidads = Unidad::join('bloques','bloques.id','=','unidads.bloqueid')
            ->select(
            Unidad::raw("CONCAT(bloquenombre,' - ',unidadnombre) AS unidad"),'unidads.id')
            ->whereIn('conjuntoid', session('dependencias'))
            ->orderBy('unidad','ASC')
            ->pluck('unidad', 'unidads.id');

        //$unidads->prepend('Seleccione la unidad', '');

        return view('admin.vehiculo.edit', compact('vehiculo', 'tipo_vehiculos', 'conjuntos', 'unidads'));

    }

    public function update(Request $request, Vehiculo $vehiculo)
    {
        $request->validate([
            'conjuntoid'=>'required',
            'unidadid'=>'required',
            'vehiculoplaca'=>'required|unique:vehiculos'
        ]);

        $vehiculo->update([
            'unidadid'=>$request->get('unidadid'),
            'tipovehiculoid'=>$request->get('tipovehiculoid'),
            'vehiculoplaca'=>$request->get('vehiculoplaca'),
            'vehiculomarca'=>$request->get('vehiculomarca'),
        ]);
        return redirect()->route('admin.vehiculos.index')->with('info','El vehiculo fue actualizado de forma exitosa');

    }

    public function destroy(Request $request, $id)
    {
        $vehiculo = vehiculo::find($id);
        $vehiculo->delete();

        if(!$request->get('vehiculos'))
            return redirect()->route('admin.vehiculos.show', $vehiculo->unidadid)->with('info','El vehiculo fue eliminado exitosamente');
        else
            return redirect()->route('admin.unidads.edit', $vehiculo->unidadid)->with('info','El vehiculo fue eliminado exitosamente');

    }
}
