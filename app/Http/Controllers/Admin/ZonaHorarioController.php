<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Zona;
use App\Models\ZonaHorario;
use Illuminate\Http\Request;

class ZonaHorarioController extends Controller
{

    public function index()
    {

    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'zonaid'=>'required',
            'fecha'=>'required',
            'horaapertura'=>'required',
            'horacierre' => 'required',
        ]);

        $zonahorario = ZonaHorario::create([
            'zonaid' => $request->get('zonaid'),
            'fecha' => $request->get('fecha'),
            'horaapertura' => $request->get('horaapertura'),
            'horacierre' => $request->get('horacierre'),
        ]);

        return redirect()->route('admin.zonaHorario.edit', $request->get('zonaid'))->with('info','El horario fue agregado de forma exitosa');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $zona = Zona::whereId($id)->pluck('zonanombre', 'id');
        // $lunes = ZonaHorario::join("zonas","zonas.id", "=", "zona_horarios.zonaid")
        //     ->join("conjuntos","conjuntos.id", "=", "zonas.conjuntoid")->whereZonaid($id)->whereDia(1)->get();
        // $martes = ZonaHorario::join("zonas","zonas.id", "=", "zona_horarios.zonaid")
        //     ->join("conjuntos","conjuntos.id", "=", "zonas.conjuntoid")->whereZonaid($id)->whereDia(2)->get();
        // $miercoles = ZonaHorario::join("zonas","zonas.id", "=", "zona_horarios.zonaid")
        //     ->join("conjuntos","conjuntos.id", "=", "zonas.conjuntoid")->whereZonaid($id)->whereDia(3)->get();
        // $jueves = ZonaHorario::join("zonas","zonas.id", "=", "zona_horarios.zonaid")
        //     ->join("conjuntos","conjuntos.id", "=", "zonas.conjuntoid")->whereZonaid($id)->whereDia(4)->get();
        // $viernes = ZonaHorario::join("zonas","zonas.id", "=", "zona_horarios.zonaid")
        //     ->join("conjuntos","conjuntos.id", "=", "zonas.conjuntoid")->whereZonaid($id)->whereDia(5)->get();
        // $sabado = ZonaHorario::join("zonas","zonas.id", "=", "zona_horarios.zonaid")
        //     ->join("conjuntos","conjuntos.id", "=", "zonas.conjuntoid")->whereZonaid($id)->whereDia(6)->get();
        // $domingo = ZonaHorario::join("zonas","zonas.id", "=", "zona_horarios.zonaid")
        //     ->join("conjuntos","conjuntos.id", "=", "zonas.conjuntoid")->whereZonaid($id)->whereDia(7)->get();

        return view('admin.zonaHorario.edit', compact('zona'));
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
