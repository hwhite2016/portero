<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ciudad;
use App\Models\Barrio;

class BarrioController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('can:admin.barrios.index')->only('index');
        $this->middleware('can:admin.barrios.create')->only('create', 'store');
        $this->middleware('can:admin.barrios.edit')->only('edit', 'update');
        $this->middleware('can:admin.barrios.destroy')->only('destroy');
    }

    public function index()
    {
        $barrios = Barrio::leftjoin("conjuntos","conjuntos.barrioid", "=", "barrios.id")
             ->join("ciudads","ciudads.id", "=", "barrios.ciudadid")
             ->select(Barrio::raw('count(conjuntos.id) as conjunto_count, barrios.id, barrios.ciudadid, ciudadnombre, barrionombre, barrioestrato'))
             ->groupBy('barrios.id', 'barrios.ciudadid', 'ciudads.ciudadnombre', 'barrionombre', 'barrioestrato')
             ->orderBy('conjunto_count', 'DESC')
             ->get();
             return view('admin.barrio.index')->with('barrios', $barrios);
    }

    public function create()
    {
        $ciudads = Ciudad::all()->pluck('ciudadnombre', 'id');
        return view('admin.barrio.create')->with('ciudads',$ciudads);
    }

    public function store(Request $request)
    {
         $request->validate([
            'ciudadid'=>'required',
            'barrionombre'=>'required'
        ]);
        $barrios = Barrio::create($request->all());
        return redirect()->route('admin.barrios.show', $barrios->ciudadid)->with('info','E barrio fue agregado de forma exitosa');
    }

    public function show($id)
    {
        $barrios = Barrio::leftjoin("conjuntos","conjuntos.barrioid", "=", "barrios.id")
            ->join("ciudads","ciudads.id", "=", "barrios.ciudadid")
            ->select(Barrio::raw('count(conjuntos.id) as conjunto_count, barrios.id, barrios.ciudadid, ciudadnombre, barrionombre, barrioestrato'))
            ->where('barrios.ciudadid', '=', $id)
            ->groupBy('barrios.id', 'barrios.ciudadid', 'ciudads.ciudadnombre', 'barrionombre', 'barrioestrato')
            ->orderBy('conjunto_count', 'DESC')
            ->get();

        return view('admin.barrio.index')->with('barrios', $barrios);
    }

    public function edit($id)
    {
        $barrio = Barrio::find($id);
        $ciudads = Ciudad::all()->pluck('ciudadnombre', 'id');
        return view('admin.barrio.edit')->with('barrio',$barrio)->with('ciudads',$ciudads);
    }

    public function update(Request $request, Barrio $barrio)
    {
         $request->validate([
            'ciudadid'=>'required',
            'barrionombre'=>'required'
        ]); 
        $barrio->update($request->all());
         return redirect()->route('admin.barrios.show', $barrio->ciudadid)->with('info','El barrio fue actualizado de forma exitosa');
    }

    public function destroy($id)
    {
        $barrio = Barrio::find($id);
        $barrio->delete();
        return redirect()->route('admin.barrios.show', $barrio->ciudadid)->with('info','El barrio fue eliminado exitosamente');
    }
}
