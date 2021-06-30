<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Parqueadero;
use App\Models\Conjunto;

class ParqueaderoController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('can:admin.parqueaderos.index')->only('index');
        $this->middleware('can:admin.parqueaderos.create')->only('create', 'store');
        $this->middleware('can:admin.parqueaderos.edit')->only('edit', 'update');
        $this->middleware('can:admin.parqueaderos.destroy')->only('destroy');
    }

    public function index()
    {

        $parqueaderos = Parqueadero::join("conjuntos","conjuntos.id", "=", "parqueaderos.conjuntoid")
             ->join('barrios','barrios.id','=','conjuntos.barrioid')
             ->select(Parqueadero::raw('parqueaderos.id, barrionombre, conjuntonombre, parqueaderonumero, parqueaderopiso, parqueaderotipo, parqueaderoestado'))
             ->whereIn('conjuntos.id', session('dependencias'))
             ->orderBy('parqueaderos.parqueaderonumero', 'DESC')
             ->get();

             return view('admin.parqueadero.index')->with('parqueaderos', $parqueaderos);
    }

    public function create()
    {
        $conjuntos = Conjunto::whereIn('conjuntos.id', session('dependencias'))->pluck('conjuntonombre', 'id');
        return view('admin.parqueadero.create')->with('conjuntos',$conjuntos);
    }

    public function store(Request $request)
    {
        $request->validate([
            'conjuntoid'=>'required',
            'parqueaderonumero'=>'required',
            'parqueaderopiso'=>'required',
            'parqueaderotipo'=>'required',
            'parqueaderonumero' => 'unique:parqueaderos,parqueaderonumero,NULL,id,conjuntoid,' . $request->get('conjuntoid')
        ]);
        $parqueaderos = Parqueadero::create($request->all());
        return redirect()->route('admin.parqueaderos.show', $parqueaderos->conjuntoid)->with('info','El parqueadero fue agregado de forma exitosa');
    }

    public function show($id)
    {
             $parqueaderos = Parqueadero::join("conjuntos","conjuntos.id", "=", "parqueaderos.conjuntoid")
             ->join('barrios','barrios.id','=','conjuntos.barrioid')
             ->select(Parqueadero::raw('parqueaderos.id, barrionombre, conjuntonombre, parqueaderonumero, parqueaderopiso, parqueaderotipo, parqueaderoestado'))
              ->where('parqueaderos.conjuntoid', '=', $id)
             ->whereIn('conjuntos.id', session('dependencias'))
             ->orderBy('parqueaderonumero', 'DESC')
             ->get();


        return view('admin.parqueadero.index')->with('parqueaderos', $parqueaderos);
    }

    public function edit($id)
    {
        $parqueadero = parqueadero::find($id);
        $conjuntos = Conjunto::whereIn('conjuntos.id', session('dependencias'))->pluck('conjuntonombre', 'id');
        return view('admin.parqueadero.edit')->with('parqueadero',$parqueadero)->with('conjuntos',$conjuntos);
    }

    public function update(Request $request, Parqueadero $parqueadero)
    {

            $validar_update = $parqueadero->id > 0 ? $parqueadero->id : "NULL";

            $request->validate([
                'conjuntoid'=>'required',
                'parqueaderonumero'=>'required',
                'parqueaderotipo'=>'required',
                'parqueaderonumero' => 'unique:parqueaderos,parqueaderonumero,' . $validar_update . ',id,conjuntoid,' . $request->get('conjuntoid')
            ]);

            $parqueadero->update($request->all());

            return redirect()->route('admin.parqueaderos.show', $parqueadero->conjuntoid)->with('info','El parqueadero fue actualizado de forma exitosa');

    }

    public function destroy($id)
    {
        $parqueadero = Parqueadero::find($id);
        $parqueadero->delete();
        return redirect()->route('admin.parqueaderos.show', $parqueadero->conjuntoid)->with('info','El parqueadero fue eliminado exitosamente');
    }
}
