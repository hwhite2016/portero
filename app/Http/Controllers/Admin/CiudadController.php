<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ciudad;
use App\Models\Pais;
use App\Models\Barrio;

class CiudadController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('can:admin.ciudads.index')->only('index');
        $this->middleware('can:admin.ciudads.create')->only('create', 'store');
        $this->middleware('can:admin.ciudads.edit')->only('edit', 'update');
        $this->middleware('can:admin.ciudads.destroy')->only('destroy');
    }

    public function index()
    {
        $ciudads = Ciudad::leftjoin("barrios","barrios.ciudadid", "=", "ciudads.id")
            ->join("pais","pais.id", "=", "ciudads.paisid")
            ->select(Ciudad::raw('count(barrios.id) as barrio_count, ciudads.id, ciudads.paisid, paisnombre, paisbandera, ciudadnombre, ciudadcodigo, ciudadabreviatura'))
            ->groupBy('ciudads.id', 'ciudads.paisid', 'pais.paisnombre', 'pais.paisbandera', 'ciudadnombre', 'ciudadcodigo', 'ciudadabreviatura')
            ->orderBy('barrio_count', 'DESC')
            ->get();
            return view('admin.ciudad.index')->with('ciudads', $ciudads);

    }

    public function create()
    {
        $paises = Pais::all()->pluck('paisnombre', 'id');
        return view('admin.ciudad.create')->with('paises',$paises);
    }

    public function store(Request $request)
    {
        $request->validate([
            'paisid'=>'required',
            'ciudadnombre'=>'required',
            'ciudadabreviatura'=>'required'
        ]);
        $ciudads = Ciudad::create($request->all());
        return redirect()->route('admin.ciudads.show', $ciudads->paisid)->with('info','La ciudad fue agregada de forma exitosa');
        
    }

    public function show($id)
    {
        $ciudads = Ciudad::leftjoin("barrios","barrios.ciudadid", "=", "ciudads.id")
            ->join("pais","pais.id", "=", "ciudads.paisid")
            ->select(Ciudad::raw('count(barrios.id) as barrio_count, ciudads.id, ciudads.paisid, paisnombre, paisbandera, ciudadnombre, ciudadcodigo, ciudadabreviatura'))
            ->where('ciudads.paisid', '=', $id)
            ->groupBy('ciudads.id', 'ciudads.paisid', 'pais.paisnombre', 'pais.paisbandera', 'ciudadnombre', 'ciudadcodigo', 'ciudadabreviatura')
            ->orderBy('barrio_count', 'DESC')
            ->get();

        return view('admin.ciudad.index')->with('ciudads', $ciudads)->with($id);
    }

    public function edit($id)
    {
        $ciudad = Ciudad::find($id);
        $paises = Pais::all()->pluck('paisnombre', 'id');
        return view('admin.ciudad.edit')->with('ciudad',$ciudad)->with('paises',$paises);
    }

    public function update(Request $request, Ciudad $ciudad)
    {
        $request->validate([
            'paisid'=>'required',
            'ciudadnombre'=>'required',
            'ciudadabreviatura'=>'required'
        ]); 
        $ciudad->update($request->all());
         return redirect()->route('admin.ciudads.show', $ciudad->paisid)->with('info','La ciudad fue actualizada de forma exitosa');

    }

    public function destroy($id)
    {
        $ciudad = Ciudad::find($id);
        $ciudad->delete();
        return redirect()->route('admin.ciudads.show', $ciudad->paisid)->with('info','La ciudad fue eliminada exitosamente');
    }
}
