<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Visitante;
use App\Models\Unidad;
use App\Models\TipoDocumento;
use App\Models\Conjunto;
use App\Models\Parqueadero;
use App\Models\Persona;

class VisitanteController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('can:admin.visitantes.index')->only('index');
        $this->middleware('can:admin.visitantes.create')->only('create', 'store', 'restaurar');
        $this->middleware('can:admin.visitantes.edit')->only('edit', 'update');
        $this->middleware('can:admin.visitantes.destroy')->only('destroy', 'hdestroy');
    }

    public function getVisitantes()
    {
        $visitantes = Visitante::join("unidads","unidads.id", "=", "visitantes.unidadid")
            ->join('bloques','bloques.id','=','unidads.bloqueid')
             ->join('conjuntos','conjuntos.id','=','bloques.conjuntoid')
             ->join('personas','personas.id','=','visitantes.personaid')
             ->join('tipo_documentos','tipo_documentos.id','=','personas.tipodocumentoid')
             ->leftjoin('parqueaderos','parqueaderos.id','=','visitantes.parqueaderoid')
             ->select(Visitante::raw('CONCAT(tipodocumentoabreviatura," " ,personadocumento) AS documento, visitantes.id, conjuntonombre, unidadnombre, CONCAT(parqueaderonumero," - Piso " ,parqueaderopiso) AS parqueadero, visitanteplaca, personanombre, personacelular, visitanteingreso, visitantesalida'))
             ->whereIn('conjuntos.id', session('dependencias'))
             ->onlyTrashed()
             ->orderBy('visitantesalida', 'DESC')
             ->get();
             return view('admin.hvisitante.index')->with('visitantes', $visitantes);
    }

    public function getInfoDocumento($id){

        $documento = Persona::wherePersonadocumento($id)->first();
        if(isset($documento)){
           return response()->json(['persona' => $documento], 200);
        }else{
            return "No se encontraron resultados" . $id ;
        }
    }

    public function index()
    {

        $visitantes = Visitante::join("unidads","unidads.id", "=", "visitantes.unidadid")
            ->join('bloques','bloques.id','=','unidads.bloqueid')
             ->join('conjuntos','conjuntos.id','=','bloques.conjuntoid')
             ->join('personas','personas.id','=','visitantes.personaid')
             ->join('tipo_documentos','tipo_documentos.id','=','personas.tipodocumentoid')
             ->leftjoin('parqueaderos','parqueaderos.id','=','visitantes.parqueaderoid')
             ->select(Visitante::raw('CONCAT(tipodocumentoabreviatura," " ,personadocumento) AS documento, visitantes.id, conjuntonombre, unidadnombre, CONCAT(parqueaderonumero," - Piso " ,parqueaderopiso) AS parqueadero, visitanteplaca, personanombre, personacelular, visitanteingreso, visitantesalida'))
             ->whereIn('conjuntos.id', session('dependencias'))
             ->orderBy('visitanteingreso', 'DESC')
             ->get();
             return view('admin.visitante.index')->with('visitantes', $visitantes);
    }

    public function create(Request $request)
    {
        $tipo_documentos = TipoDocumento::all()->pluck('tipodocumentonombre', 'id');
        $conjuntos = Conjunto::whereIn('conjuntos.id', session('dependencias'))->pluck('conjuntonombre', 'id');

        $parqueaderos = Parqueadero::where('parqueaderotipo','=','Visitante')
            ->where('parqueaderoestado','=',0)
            ->whereIn('conjuntoid', session('dependencias'))->pluck('parqueaderonumero', 'id');

        $parqueaderos->prepend('Seleccione un parqueadero disponible', '');

        $unidads = Unidad::join('bloques','bloques.id','=','unidads.bloqueid')
            ->select(
            DB::raw("CONCAT(bloquenombre,' - ',unidadnombre) AS unidad"),'unidads.id')
            ->whereIn('conjuntoid', session('dependencias'))
            ->orderBy('unidad','ASC')
            ->pluck('unidad', 'unidads.id');

        return view('admin.visitante.create', compact('tipo_documentos', 'conjuntos', 'unidads', 'parqueaderos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'conjuntoid'=>'required',
            'unidadid'=>'required',
            'tipodocumentoid'=>'required',
            'personadocumento'=>'required',
            'personanombre'=>'required',
        ]);
        if (Persona::where('personadocumento', '=', $request->get('personadocumento'))->exists()) {
            $persona = Persona::where('personadocumento','=',$request->get('personadocumento'))->first();
        }else{

            $persona = Persona::create([
                'tipodocumentoid'=>$request->get('tipodocumentoid'),
                'personadocumento'=>$request->get('personadocumento'),
                'personanombre'=>$request->get('personanombre'),
                'personacelular'=>$request->get('personacelular'),
             ]);
        }

        if (Visitante::withTrashed()->where('personaid','=',$persona->id)->where('visitantesalida', '=', NULL)->first()){
            return redirect()->route('admin.visitantes.index')->with('info','El visitante NO puede ingresar, ya que aun se encuentra dentro de la copropiedad');
        }else{
            Visitante::create([
                'personaid'=>$persona->id,
                'unidadid'=>$request->get('unidadid'),
                'parqueaderoid'=>$request->get('parqueaderoid'),
                'visitanteplaca'=>$request->get('visitanteplaca'),
                'visitanteingreso'=> now(),
                'visitanteobservacion'=>$request->get('visitanteobservacion'),
            ]);
            if($request->get('parqueaderoid')){
                $parqueadero = Parqueadero::find($request->get('parqueaderoid'));
                $parqueadero->update(['parqueaderoestado'=>1]);
            }

            return redirect()->route('admin.visitantes.index')->with('info','El visitante ingresó a la copropiedad de forma exitosa');

        }


    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $visitante = Visitante::find($id);
        // $unidads = Unidad::whereIn('unidads.id', session('dependencias'))->pluck('conjuntonombre', 'id');
        // return view('admin.visitantes.edit')->with('visitante',$visitante)->with('unidads',$unidads);

        $tipo_documentos = TipoDocumento::all()->pluck('tipodocumentonombre', 'id');
        $conjuntos = Conjunto::whereIn('conjuntos.id', session('dependencias'))->pluck('conjuntonombre', 'id');

        $parqueaderos = Parqueadero::where('parqueaderotipo','=','Visitante')
            ->where('parqueaderoestado','=',0)
            ->whereIn('conjuntoid', session('dependencias'))->pluck('parqueaderonumero', 'id');

        $parqueaderos->prepend('Seleccione un parqueadero disponible', '');

        $unidads = Unidad::join('bloques','bloques.id','=','unidads.bloqueid')
            ->select(
            DB::raw("CONCAT(bloquenombre,' - ',unidadnombre) AS unidad"),'unidads.id')
            ->whereIn('conjuntoid', session('dependencias'))
            ->orderBy('unidad','ASC')
            ->pluck('unidad', 'unidads.id');

        return view('admin.visitante.edit', compact('visitante','tipo_documentos', 'conjuntos', 'unidads', 'parqueaderos'));

    }

    public function update(Request $request, Visitante $visitante)
    {
        if ($request->get('parqueaderoestado')){
            Visitante::find($request->get('id'))->update(['parqueaderoestado' => $request->get('parqueaderoestado')]);
        }else{
            $request->validate([
                'conjuntoid'=>'required',
                'parqueaderonumero'=>'required',
                'parqueaderotipo'=>'required',
            ]);

            $visitante->update($request->all());
            return redirect()->route('admin.visitantes.show', $visitante->conjuntoid)->with('info','El parqueadero fue actualizado de forma exitosa');
        }
    }

    public function restaurar($id)
    {
        Visitante::withTrashed()->where('id', $id)->restore();
        $visitante = Visitante::find($id);
        $visitante->update(['visitantesalida'=>NULL]);

        return redirect()->route('admin.visitantes.getVisitantes')->with('info','El visitante ha reingresado de forma exitosa.');
    }

    public function hdestroy($id)
    {
        $visitante = Visitante::withTrashed()->find($id);
        $visitante->forceDelete();
        return redirect()->route('admin.visitantes.getVisitantes')->with('info','El visitante ha sido eliminado de forma exitosa.');
    }

    public function destroy(Visitante $visitante)
    {
        //$visitante = Visitante::find($id);
        $visitante->update(['visitantesalida'=>now()]);
        $visitante->delete();
        return redirect()->route('admin.visitantes.index')->with('info','El visitante ha salido del conjunto de forma exitosa.');
    }
}
