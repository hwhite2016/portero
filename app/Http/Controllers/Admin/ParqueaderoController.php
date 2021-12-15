<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Parqueadero;
use App\Models\Conjunto;
use App\Models\EstadoParqueadero;
use App\Models\TipoParqueadero;

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
        return view('admin.parqueadero.index');
    }

    public function create()
    {
        $conjuntos = Conjunto::whereIn('conjuntos.id', session('dependencias'))->pluck('conjuntonombre', 'id');
        $tipo_parqueaderos = TipoParqueadero::all()->pluck('tipoparqueaderonombre', 'id');
        $estado_parqueaderos = EstadoParqueadero::all()->pluck('estadoparqueaderonombre', 'id');
        return view('admin.parqueadero.create', compact('conjuntos','tipo_parqueaderos','estado_parqueaderos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'conjuntoid'=>'required',
            'parqueaderonumero'=>'required',
            'parqueaderopiso'=>'required',
            'tipoparqueaderoid'=>'required',
            'estadoparqueaderoid'=>'required',
            'parqueaderonumero' => 'unique:parqueaderos,parqueaderonumero,NULL,id,conjuntoid,' . $request->get('conjuntoid')
        ]);
        $parqueaderos = Parqueadero::create($request->all());

        return redirect()->route('admin.parqueaderos.index')->with('info','El parqueadero fue agregado de forma exitosa');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $parqueadero = parqueadero::find($id);
        $conjuntos = Conjunto::whereIn('conjuntos.id', session('dependencias'))->pluck('conjuntonombre', 'id');
        $tipo_parqueaderos = TipoParqueadero::all()->pluck('tipoparqueaderonombre', 'id');
        $estado_parqueaderos = EstadoParqueadero::all()->pluck('estadoparqueaderonombre', 'id');
        return view('admin.parqueadero.edit', compact('parqueadero','conjuntos','tipo_parqueaderos','estado_parqueaderos'));
    }

    public function update(Request $request, Parqueadero $parqueadero)
    {

            $validar_update = $parqueadero->id > 0 ? $parqueadero->id : "NULL";

            $request->validate([
                'conjuntoid'=>'required',
                'parqueaderonumero'=>'required',
                'tipoparqueaderoid'=>'required',
                'estadoparqueaderoid'=>'required',
                'parqueaderonumero' => 'unique:parqueaderos,parqueaderonumero,' . $validar_update . ',id,conjuntoid,' . $request->get('conjuntoid')
            ]);

            $parqueadero->update($request->all());

            return redirect()->route('admin.parqueaderos.show', $parqueadero->conjuntoid)->with('info','El parqueadero fue actualizado de forma exitosa');

    }

    public function destroy($id)
    {
        $parqueadero = Parqueadero::find($id);
        $parqueadero->delete();
        return redirect()->route('admin.parqueaderos.index')->with('info','El parqueadero fue eliminado exitosamente');

    }
}
