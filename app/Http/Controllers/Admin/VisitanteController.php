<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\VisitantesImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Visitante;
use App\Models\Unidad;
use App\Models\TipoDocumento;
use App\Models\Conjunto;
use App\Models\Parqueadero;
use App\Models\Persona;
use App\Models\Residente;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
//use Maatwebsite\Excel\Facades\Excel;
use Excel;


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
        $user = User::find(Auth::user()->id);
        if ($user->hasRole('Residente')){
            $residente = Residente::where('personaid', Auth::user()->personaid)->first();
            $visitantes = Visitante::join("unidads","unidads.id", "=", "visitantes.unidadid")
                ->join('bloques','bloques.id','=','unidads.bloqueid')
                ->join('conjuntos','conjuntos.id','=','bloques.conjuntoid')
                ->join('personas','personas.id','=','visitantes.personaid')
                ->join('tipo_documentos','tipo_documentos.id','=','personas.tipodocumentoid')
                ->leftjoin('parqueaderos','parqueaderos.id','=','visitantes.parqueaderoid')
                ->select(Visitante::raw('CONCAT(tipodocumentoabreviatura," " ,personadocumento) AS documento, visitantes.id, conjuntonombre, unidadnombre, CONCAT(parqueaderonumero," - Piso " ,parqueaderopiso) AS parqueadero, visitanteplaca, personanombre, personacelular, visitanteingreso, visitantesalida, visitantenumero'))
                ->whereIn('conjuntos.id', session('dependencias'))
                ->where('unidads.id', $residente->unidadid)
                ->onlyTrashed()
                ->orderBy('visitantesalida', 'DESC')
                ->get();

        }else{
            $visitantes = Visitante::join("unidads","unidads.id", "=", "visitantes.unidadid")
                ->join('bloques','bloques.id','=','unidads.bloqueid')
                ->join('conjuntos','conjuntos.id','=','bloques.conjuntoid')
                ->join('personas','personas.id','=','visitantes.personaid')
                ->join('tipo_documentos','tipo_documentos.id','=','personas.tipodocumentoid')
                ->leftjoin('parqueaderos','parqueaderos.id','=','visitantes.parqueaderoid')
                ->select(Visitante::raw('CONCAT(tipodocumentoabreviatura," " ,personadocumento) AS documento, visitantes.id, conjuntonombre, unidadnombre, CONCAT(parqueaderonumero," - Piso " ,parqueaderopiso) AS parqueadero, visitanteplaca, personanombre, personacelular, visitanteingreso, visitantesalida, visitantenumero'))
                ->whereIn('conjuntos.id', session('dependencias'))
                ->onlyTrashed()
                ->orderBy('visitantesalida', 'DESC')
                ->get();

        }
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
        $user = User::find(Auth::user()->id);
        if ($user->hasRole('Residente')){
            $residente = Residente::where('personaid', Auth::user()->personaid)->first();
            $visitantes = Visitante::join("unidads","unidads.id", "=", "visitantes.unidadid")
                ->join('bloques','bloques.id','=','unidads.bloqueid')
                ->join('conjuntos','conjuntos.id','=','bloques.conjuntoid')
                ->join('personas','personas.id','=','visitantes.personaid')
                ->join('tipo_documentos','tipo_documentos.id','=','personas.tipodocumentoid')
                ->leftjoin('parqueaderos','parqueaderos.id','=','visitantes.parqueaderoid')
                ->select(Visitante::raw('CONCAT(tipodocumentoabreviatura," " ,personadocumento) AS documento, visitantes.id, conjuntonombre, unidadnombre, CONCAT(parqueaderonumero," - Piso " ,parqueaderopiso) AS parqueadero, visitanteplaca, personanombre, personacelular, visitanteingreso, visitantesalida, visitantenumero'))
                ->whereIn('conjuntos.id', session('dependencias'))
                ->where('unidads.id', $residente->unidadid)
                ->orderBy('visitanteingreso', 'DESC')
                ->get();

        }else{
            $visitantes = Visitante::join("unidads","unidads.id", "=", "visitantes.unidadid")
                ->join('bloques','bloques.id','=','unidads.bloqueid')
                ->join('conjuntos','conjuntos.id','=','bloques.conjuntoid')
                ->join('personas','personas.id','=','visitantes.personaid')
                ->join('tipo_documentos','tipo_documentos.id','=','personas.tipodocumentoid')
                ->leftjoin('parqueaderos','parqueaderos.id','=','visitantes.parqueaderoid')
                ->select(Visitante::raw('CONCAT(tipodocumentoabreviatura," " ,personadocumento) AS documento, visitantes.id, conjuntonombre, unidadnombre, CONCAT(parqueaderonumero," - Piso " ,parqueaderopiso) AS parqueadero, visitanteplaca, personanombre, personacelular, visitanteingreso, visitantesalida, visitantenumero'))
                ->whereIn('conjuntos.id', session('dependencias'))
                ->where('visitanteingreso','<=', now()->add(6, 'day'))
                ->orderBy('visitanteingreso', 'DESC')
                ->get();

        }
        return view('admin.visitante.index')->with('visitantes', $visitantes);
    }

    public function create(Request $request)
    {
        $tipo_documentos = TipoDocumento::all()->pluck('tipodocumentonombre', 'id');
        $conjuntos = Conjunto::whereIn('conjuntos.id', session('dependencias'))->pluck('conjuntonombre', 'id');

        $user = User::find(Auth::user()->id);

        if ($user->hasRole('Residente')){
            $parqueaderos = Parqueadero::join('tipo_parqueaderos', 'tipo_parqueaderos.id','parqueaderos.tipoparqueaderoid')
                ->where('tipoparqueaderoid','<>',1)
                ->select(Parqueadero::raw("CONCAT(parqueaderonumero,' - ', tipoparqueaderonombre, ' (Piso ', parqueaderopiso,')') AS parqueaderonumero"),'parqueaderos.id')
                ->where('estadoparqueaderoid','=',1)
                ->whereIn('conjuntoid', session('dependencias'))->pluck('parqueaderonumero', 'parqueaderos.id');

            $unidads = Residente::join('unidads','unidads.id','=','residentes.unidadid')
                ->join('bloques','bloques.id','=','unidads.bloqueid')
                ->select(
                DB::raw("CONCAT(bloquenombre,' - ',unidadnombre) AS unidad"),'unidads.id')
                ->whereIn('conjuntoid', session('dependencias'))
                ->where('residentes.personaid', Auth::user()->personaid)
                ->orderBy('unidad','ASC')
                ->pluck('unidad', 'unidads.id');
        }else{
            $parqueaderos = Parqueadero::join('tipo_parqueaderos', 'tipo_parqueaderos.id','parqueaderos.tipoparqueaderoid')
                ->where('tipoparqueaderoid','<>',1)
                ->select(Parqueadero::raw("CONCAT(parqueaderonumero,' - ', tipoparqueaderonombre, ' (Piso ', parqueaderopiso,')') AS parqueaderonumero"),'parqueaderos.id')
                ->where('estadoparqueaderoid','=',1)
                ->whereIn('conjuntoid', session('dependencias'))->pluck('parqueaderonumero', 'parqueaderos.id');

            $unidads = Unidad::join('bloques','bloques.id','=','unidads.bloqueid')
                ->select(
                DB::raw("CONCAT(bloquenombre,' - ',unidadnombre) AS unidad"),'unidads.id')
                ->whereIn('conjuntoid', session('dependencias'))
                ->where('unidads.estado_id', 4)
                ->orderBy('unidad','ASC')
                ->pluck('unidad', 'unidads.id');
        }
        $parqueaderos->prepend('Seleccione un parqueadero disponible', '');
        return view('admin.visitante.create', compact('tipo_documentos', 'conjuntos', 'unidads', 'parqueaderos'));
    }

    public function store(Request $request)
    {
        $fecha = now();
        $user = User::find(Auth::user()->id);
        if ($user->hasRole('Residente')){
            if($request->get('visitanteingreso')) $fecha = $request->get('visitanteingreso');
            $request->validate([
                'conjuntoid'=>'required',
                'unidadid'=>'required',
                'tipodocumentoid'=>'required',
                'personadocumento'=>'required|min:3|alpha_num',
                'personanombre'=>'required|min:3',
                'visitanteingreso'=>'required',
            ]);
        }else{
            $request->validate([
                'conjuntoid'=>'required',
                'unidadid'=>'required',
                'tipodocumentoid'=>'required',
                'personadocumento'=>'required|min:3|alpha_num',
                'personanombre'=>'required|min:3',
            ]);
        }
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
            return redirect()->route('admin.visitantes.index')->with('error','El visitante aún se encuentra dentro de la copropiedad, debe darle salida para que pueda volver a ingresar');
        }else{

            Visitante::create([
                'personaid'=>$persona->id,
                'unidadid'=>$request->get('unidadid'),
                'parqueaderoid'=>$request->get('parqueaderoid'),
                'visitanteplaca'=>$request->get('visitanteplaca'),
                'visitanteingreso'=> $fecha,
                'visitanteobservacion'=>$request->get('visitanteobservacion'),
                'visitantenumero'=>$request->get('visitantenumero'),
            ]);
            if($request->get('parqueaderoid')){
                $parqueadero = Parqueadero::find($request->get('parqueaderoid'));
                $parqueadero->update(['estadoparqueaderoid'=>2]);
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

        $parqueaderos = Parqueadero::join('tipo_parqueaderos', 'tipo_parqueaderos.id','parqueaderos.tipoparqueaderoid')
                ->where('tipoparqueaderoid','<>',1)
                ->select(Parqueadero::raw("CONCAT(parqueaderonumero,' - ', tipoparqueaderonombre, ' (Piso ', parqueaderopiso,')') AS parqueaderonumero"),'parqueaderos.id')
                ->whereIn('estadoparqueaderoid',[1,2])
                ->whereIn('conjuntoid', session('dependencias'))->pluck('parqueaderonumero', 'parqueaderos.id');


        $parqueaderos->prepend('Seleccione un parqueadero disponible', '');

        $unidads = Unidad::join('bloques','bloques.id','=','unidads.bloqueid')
            ->select(
            DB::raw("CONCAT(bloquenombre,' - ',unidadnombre) AS unidad"),'unidads.id')
            ->whereIn('conjuntoid', session('dependencias'))
            ->where('unidads.id', $visitante->unidadid)
            ->where('unidads.estado_id', 4)
            ->orderBy('unidad','ASC')
            ->pluck('unidad', 'unidads.id');

        return view('admin.visitante.edit', compact('visitante','tipo_documentos', 'conjuntos', 'unidads', 'parqueaderos'));

    }

    public function update(Request $request, Visitante $visitante)
    {

        if ($request->get('parqueaderoid')){
            $request->validate([
                'conjuntoid'=>'required',
                'unidadid'=>'required',
                'visitanteplaca'=>'required',
            ]);
            $visitante->update([
                'parqueaderoid' => $request->get('parqueaderoid'),
                'visitanteplaca'=>$request->get('visitanteplaca'),
                'visitanteingreso'=> $request->get('visitanteingreso'),
                'visitanteobservacion'=>$request->get('visitanteobservacion'),
                'visitantenumero'=>$request->get('visitantenumero'),
            ]);
        }else{
            $request->validate([
                'conjuntoid'=>'required',
                'unidadid'=>'required',
            ]);

            $visitante->update([
                'visitanteingreso'=> $request->get('visitanteingreso'),
                'visitanteobservacion'=>$request->get('visitanteobservacion'),
                'visitantenumero'=>$request->get('visitantenumero'),
            ]);
        }
        return redirect()->route('admin.visitantes.index')->with('info','El parqueadero fue actualizado de forma exitosa');
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

    public function importForm(){
        return view('admin.visitante.import');
    }

    public function import(Request $request)
    {

        $import = new VisitantesImport();
        Excel::import($import, request()->file('visitantes'));
        return view('admin.visitante.import', ['numRows'=>$import->getRowCount()]);
    }
}
