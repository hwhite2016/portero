<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mascota;
use App\Models\TipoMascota;
use App\Models\Conjunto;
use App\Models\Unidad;

class MascotaController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('can:admin.mascotas.index')->only('index');
        $this->middleware('can:admin.mascotas.create')->only('create', 'store');
        $this->middleware('can:admin.mascotas.edit')->only('edit', 'update');
        $this->middleware('can:admin.mascotas.destroy')->only('destroy');
    }

    public function index()
    {

        $mascotas = Mascota::join("unidads","unidads.id", "=", "mascotas.unidadid")
             ->join('bloques','bloques.id','=','unidads.bloqueid')
             ->join('conjuntos','conjuntos.id','=','bloques.conjuntoid')
             ->join('tipo_mascotas','tipo_mascotas.id','=','mascotas.tipomascotaid')
             ->select(Mascota::raw('mascotas.id, conjuntonombre, bloquenombre, unidadnombre, tipomascotaid, tipomascotanombre, mascotaraza, mascotanombre, mascotaedad'))
             ->whereIn('conjuntos.id', session('dependencias'))
             ->orderBy('unidadnombre', 'ASC')
             ->get();

             return view('admin.mascota.index')->with('mascotas', $mascotas);
    }

    public function create(Request $request)
    {
        $tipo_mascotas = Tipomascota::all()->pluck('tipomascotanombre', 'id');
        $conjuntos = Conjunto::whereIn('conjuntos.id', session('dependencias'))->pluck('conjuntonombre', 'id');

        $unidads = Unidad::join('bloques','bloques.id','=','unidads.bloqueid')
            ->select(
            Unidad::raw("CONCAT(bloquenombre,' - ',unidadnombre) AS unidad"),'unidads.id')
            ->whereIn('conjuntoid', session('dependencias'))
            ->orderBy('unidad','ASC')
            ->pluck('unidad', 'unidads.id');

        $unidads->prepend('Seleccione la unidad', '');

        return view('admin.mascota.create', compact('tipo_mascotas', 'conjuntos', 'unidads'));
    }

    public function createModal(Request $request, $id)
    {
        $tipo_mascotas = Tipomascota::all()->pluck('tipomascotanombre', 'id');
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

        return view('admin.mascota.createModal', compact('tipo_mascotas', 'conjuntos', 'unidads'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'conjuntoid'=>'required',
            'unidadid'=>'required',
            'tipomascotaid' => 'required'
        ]);

        mascota::create([
            'unidadid'=>$request->get('unidadid'),
            'tipomascotaid'=>$request->get('tipomascotaid'),
            'mascotaraza'=>$request->get('mascotaraza'),
            'mascotanombre'=>$request->get('mascotanombre'),
            'mascotaedad'=>$request->get('mascotaedad')
        ]);
        if(!$request->get('mascotas'))
            return redirect()->route('admin.mascotas.index')->with('info','La mascota fue agregada de forma exitosa');
        else
            return redirect()->route('admin.unidads.edit', $request->get('unidadid'))->with('info','La mascota fue agregada de forma exitosa');
    }

    public function show($id)
    {
        $mascotas = Mascota::join("unidads","unidads.id", "=", "mascotas.unidadid")
        ->join('bloques','bloques.id','=','unidads.bloqueid')
        ->join('conjuntos','conjuntos.id','=','bloques.conjuntoid')
        ->join('tipo_mascotas','tipo_mascotas.id','=','mascotas.tipomascotaid')
        ->select(Mascota::raw('mascotas.id, conjuntonombre, bloquenombre, unidadnombre, tipomascotaid, tipomascotanombre, mascotaraza, mascotanombre, mascotaedad'))
        ->where('unidads.id', $id)
        ->whereIn('conjuntos.id', session('dependencias'))
        ->orderBy('unidadnombre', 'ASC')
        ->get();

        return view('admin.mascota.index')->with('mascotas', $mascotas);
    }

    public function edit($id)
    {
        $mascota = mascota::find($id);
        $tipo_mascotas = Tipomascota::all()->pluck('tipomascotanombre', 'id');
        $conjuntos = Conjunto::whereIn('conjuntos.id', session('dependencias'))->pluck('conjuntonombre', 'id');
        $unidads = Unidad::join('bloques','bloques.id','=','unidads.bloqueid')
            ->select(
            Unidad::raw("CONCAT(bloquenombre,' - ',unidadnombre) AS unidad"),'unidads.id')
            ->whereIn('conjuntoid', session('dependencias'))
            ->orderBy('unidad','ASC')
            ->pluck('unidad', 'unidads.id');

        //$unidads->prepend('Seleccione la unidad', '');

        return view('admin.mascota.edit', compact('mascota', 'tipo_mascotas', 'conjuntos', 'unidads'));

    }

    public function update(Request $request, mascota $mascota)
    {
        $request->validate([
            'conjuntoid'=>'required',
            'unidadid'=>'required',
            'tipomascotaid'=>'required'
        ]);

        $mascota->update([
            'unidadid'=>$request->get('unidadid'),
            'tipomascotaid'=>$request->get('tipomascotaid'),
            'mascotaraza'=>$request->get('mascotaraza'),
            'mascotanombre'=>$request->get('mascotanombre'),
            'mascotaedad'=>$request->get('mascotaedad'),
        ]);
        return redirect()->route('admin.mascotas.index')->with('info','La mascota fue actualizada de forma exitosa');

    }

    public function destroy(Request $request, $id)
    {
        $mascota = mascota::find($id);
        $mascota->delete();

        if(!$request->get('mascotas'))
            return redirect()->route('admin.mascotas.show', $mascota->unidadid)->with('info','La mascota fue eliminada exitosamente');
        else
            return redirect()->route('admin.unidads.edit', $mascota->unidadid)->with('info','La mascota fue eliminada exitosamente');
    }
}
