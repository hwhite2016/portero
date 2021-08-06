<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bloque;
use App\Models\Conjunto;
use App\Models\TipoBloque;

//use App\Http\Requests\ValidarFormularioRequest;

class BloqueController extends Controller
{
    public function __construct(){

        $this->middleware('auth');
        $this->middleware('can:admin.bloques.index')->only('index');
        $this->middleware('can:admin.bloques.create')->only('create', 'store');
        $this->middleware('can:admin.bloques.edit')->only('edit', 'update');
        $this->middleware('can:admin.bloques.destroy')->only('destroy');
    }

    public function index()
    {

        $bloques = Bloque::leftjoin("unidads","unidads.bloqueid", "=", "bloques.id")
             ->join("conjuntos","conjuntos.id", "=", "bloques.conjuntoid")
             ->join('barrios','barrios.id','=','conjuntos.barrioid')
             ->select(bloque::raw('count(unidads.id) as unidad_count, bloques.id, bloques.conjuntoid, barrionombre, conjuntonombre, bloquenombre'))
             ->whereIn('conjuntos.id', session('dependencias'))
             ->groupBy('bloques.id', 'bloques.conjuntoid', 'barrionombre', 'conjuntos.conjuntonombre', 'bloquenombre')
             ->orderBy('bloquenombre', 'DESC')
             ->get();
             return view('admin.bloque.index')->with('bloques', $bloques);
    }

    public function create()
    {

        $conjuntos = Conjunto::whereIn('conjuntos.id', session('dependencias'))->pluck('conjuntonombre', 'id');
        $tipo_bloques = TipoBloque::all()->pluck('tipobloquenombre', 'tipobloquenombre');
        return view('admin.bloque.create')->with('conjuntos',$conjuntos)->with('tipo_bloques',$tipo_bloques);
    }

    public function store(Request $request)
    {

        $request->validate([
            'conjuntoid'=>'required',
            'bloquenombre'=>'required',
            'bloquenombre' => 'unique:bloques,bloquenombre,NULL,id,conjuntoid,' . $request->get('conjuntoid')
        ]);
        $bloques = Bloque::create([
            'conjuntoid'=>$request->get('conjuntoid'),
            'bloquenombre'=>$request->get('tipobloqueid').' '.$request->get('bloquenombre'),
        ]);

        return redirect()->route('admin.bloques.show', $bloques->conjuntoid)->with('info','El bloque fue agregado de forma exitosa');
    }

    public function show($id)
    {

        $bloques = Bloque::leftjoin("unidads","unidads.bloqueid", "=", "bloques.id")
             ->join("conjuntos","conjuntos.id", "=", "bloques.conjuntoid")
             ->join('barrios','barrios.id','=','conjuntos.barrioid')
             ->select(bloque::raw('count(unidads.id) as unidad_count, bloques.id, bloques.conjuntoid, barrionombre, conjuntonombre, bloquenombre'))
             ->where('bloques.conjuntoid', '=', $id)
             ->whereIn('conjuntos.id', session('dependencias'))
             ->groupBy('bloques.id', 'bloques.conjuntoid', 'barrionombre', 'conjuntos.conjuntonombre', 'bloquenombre')
             ->orderBy('bloquenombre', 'DESC')
             ->get();

        return view('admin.bloque.index')->with('bloques', $bloques);
    }

    public function edit($id)
    {

        $bloque = Bloque::find($id);
        $conjuntos = Conjunto::whereIn('conjuntos.id', session('dependencias'))->pluck('conjuntonombre', 'id');
        return view('admin.bloque.edit')->with('bloque',$bloque)->with('conjuntos',$conjuntos);
    }

    public function update(Request $request, Bloque $bloque)
    {
        $validar_update = $bloque->id > 0 ? $bloque->id : "NULL";

        $request->validate([
            'conjuntoid'=>'required',
            'bloquenombre'=>'required',
            'bloquenombre' => 'unique:bloques,bloquenombre,'.$validar_update.',id,conjuntoid,' . $request->get('conjuntoid')
        ]);
        $bloque->update($request->all());
         return redirect()->route('admin.bloques.show', $bloque->conjuntoid)->with('info','El bloque fue actualizado de forma exitosa');
    }

    public function destroy($id)
    {

        $bloque = Bloque::find($id);
        if(count($bloque->unidads)){
            return redirect()->route('admin.bloques.show', $bloque->conjuntoid)->with('warning','El bloque no se puede eliminar ya que contiene unidades');
        }
        $bloque->delete();
        return redirect()->route('admin.bloques.show', $bloque->conjuntoid)->with('info','El bloque fue eliminado exitosamente');
    }
}
