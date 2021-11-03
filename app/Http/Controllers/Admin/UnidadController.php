<?php

namespace App\Http\Controllers\Admin;

use App\Exports\UnidadsExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Unidad;
use App\Models\Bloque;
use App\Models\Parqueadero;
use App\Models\TipoUnidad;
use App\Models\ClaseUnidad;
use App\Models\EstadoRegistro;
use App\Models\Residente;
use App\Models\Vehiculo;
use App\Models\Mascota;
use App\Models\Persona;
use App\Models\Registro;
use App\Models\TipoDocumento;
use App\Models\TipoPropietario;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;

class UnidadController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('can:admin.unidads.index')->only('index');
        $this->middleware('can:admin.unidads.create')->only('create', 'store');
        $this->middleware('can:admin.unidads.edit')->only('edit', 'update');
        $this->middleware('can:admin.unidads.destroy')->only('destroy');
    }

    public function index(Request $request)
    {
       return view('admin.unidad.index');
    }

    public function create(Request $request)
    {
        if($request->get('bloqueid') > 0){
            $bloqueid = $request->get('bloqueid');
            $bloques = Bloque::whereIn('conjuntoid', session('dependencias'))
            ->whereId($bloqueid)
            ->pluck('bloquenombre', 'id');
        }else{
            $bloqueid = null;
            $bloques = Bloque::whereIn('conjuntoid', session('dependencias'))->pluck('bloquenombre', 'id');
        }

        $parqueaderos = Parqueadero::whereIn('conjuntoid', session('dependencias'))->pluck('parqueaderonumero', 'id');
        $tipo_unidads = TipoUnidad::all()->pluck('tipounidadnombre', 'tipounidadnombre');
        $tipo_propietarios = TipoPropietario::all()->pluck('tipopropietarionombre', 'id');
        $clase_unidads = ClaseUnidad::select(
            DB::raw("CONCAT(claseunidadnombre,' (',claseunidaddescripcion,')') AS clasenombre"),'id')
            ->whereIn('conjuntoid', session('dependencias'))
            ->orderBy('id', 'DESC')
            ->pluck('clasenombre', 'id');

            return view('admin.unidad.create', compact('bloques','tipo_unidads','clase_unidads','tipo_propietarios','parqueaderos', 'bloqueid'));    }

    public function store(Request $request)
    {
         $request->validate([
            'bloqueid'=>'required',
            'unidadnombre'=>'required',
            'claseunidadid'=>'required',
            'unidadnombre' => 'unique:unidads,unidadnombre,NULL,id,bloqueid,' . $request->get('bloqueid')
        ]);
        $unidad = Unidad::create([
            'bloqueid'=>$request->get('bloqueid'),
            'unidadnombre'=>$request->get('tipounidadid').' '.$request->get('unidadnombre'),
            'claseunidadid'=>$request->get('claseunidadid'),
            'tipopropietarioid'=>$request->get('tipopropietarioid')
        ]);

        $unidad->parqueaderos()->sync($request->parqueaderos);
        return redirect()->route('admin.unidads.edit', $unidad->id)->with('info','La unidad fue agregada de forma exitosa');

    }

    public function export($texto)
    {
         $export = new UnidadsExport(['texto' => $texto]);
        return Excel::download($export, 'unidades.xlsx');
    }

    public function getModal($id)
    {

        $tipo_documentos = TipoDocumento::all()->pluck('tipodocumentonombre', 'id');
        $conjuntos = Unidad::join('bloques','bloques.id','=','unidads.bloqueid')
            ->join('conjuntos','conjuntos.id','=','bloques.conjuntoid')
            ->select('conjuntonombre','conjuntos.id')
            ->where('unidads.id', '=', $id)
            ->pluck('conjuntonombre', 'id');

        $unidads = Unidad::join('bloques','bloques.id','=','unidads.bloqueid')
            ->select(
            Unidad::raw("CONCAT(bloquenombre,' - ',unidadnombre) AS unidad"),'unidads.id')
            ->where('unidads.id', '=', $id)
            ->pluck('unidad', 'unidads.id');

        //$unidads->prepend('Seleccione la unidad', '');

        return view('admin.unidad.createModal', compact('tipo_documentos', 'conjuntos', 'unidads'));

    }

    public function show($id)
    {
        // $unidads = Unidad::leftjoin("residentes","residentes.unidadid", "=", "unidads.id")
        // ->leftjoin("clase_unidads", "clase_unidads.id", "=", "unidads.claseunidadid")
        // ->join("bloques","bloques.id", "=", "unidads.bloqueid")
        // ->join("conjuntos","conjuntos.id", "=", "bloques.conjuntoid")
        // ->select(Unidad::raw('count(residentes.id) as residente_count, unidads.id, unidads.bloqueid, conjuntonombre, bloques.bloquenombre, unidads.claseunidadid, clase_unidads.claseunidadnombre, clase_unidads.claseunidaddescripcion, unidadnombre, estado_id'))
        // ->where('unidads.bloqueid', '=', $id)
        // ->whereIn('bloques.conjuntoid', session('dependencias'))
        // ->groupBy('unidads.id', 'unidads.bloqueid','conjuntonombre', 'bloques.bloquenombre', 'unidads.claseunidadid', 'clase_unidads.claseunidadnombre', 'clase_unidads.claseunidaddescripcion', 'unidadnombre', 'estado_id')
        // ->orderBy('bloquenombre', 'ASC')
        // ->orderBy('unidadnombre', 'ASC')
        // ->get();

        //return view('admin.unidad.index', compact('unidads','bloqueid'));
        return view('admin.unidad.index', compact('id'));

    }

    public function edit(Request $request, $id)
    {
        $unidad = Unidad::find($id);
        $bloqueid = NULL;
        if($request->get('bloqueid')) $bloqueid = $unidad->bloqueid;

        $bloques = Bloque::whereIn('conjuntoid', session('dependencias'))->pluck('bloquenombre', 'id');
        $parqueaderos = Parqueadero::whereIn('conjuntoid', session('dependencias'))->pluck('parqueaderonumero', 'id');
        $tipo_unidads = TipoUnidad::all()->pluck('tipounidadnombre', 'tipounidadnombre');
        $tipo_propietarios = TipoPropietario::all()->pluck('tipopropietarionombre', 'id');
        $estados = EstadoRegistro::all()->pluck('estadonombre', 'id');
        $clase_unidads = ClaseUnidad::select(
            DB::raw("CONCAT(claseunidadnombre,' (',claseunidaddescripcion,')') AS clasenombre"),'id')
            ->whereIn('conjuntoid', session('dependencias'))
            ->pluck('clasenombre', 'id');
        $propietario = Persona::join('unidads', 'propietarioid', 'personas.id')
            ->where('unidads.id', $id)->pluck('personanombre', 'personas.id');

        $residentes = Residente::join('tipo_residentes', 'tipo_residentes.id', '=', 'tiporesidenteid')
        ->join('personas', 'personas.id', '=', 'personaid')
        ->join('unidads', 'unidads.id', '=', 'unidadid')
        ->join('relations', 'relations.id', '=', 'relationid')
        ->select(Residente::raw('residentes.id, personanombre, tiporesidentenombre, personacelular, relationname' ))
        ->where('unidads.id', $id)
        ->get();
        $vehiculos = Vehiculo::join('tipo_vehiculos', 'tipo_vehiculos.id', '=', 'tipovehiculoid')
        ->join('unidads', 'unidads.id', '=', 'unidadid')
        ->select(Vehiculo::raw('vehiculos.id, tipovehiculonombre, vehiculomarca, vehiculoplaca' ))
        ->where('unidads.id', $id)
        ->get();
        $mascotas = Mascota::join('tipo_mascotas', 'tipo_mascotas.id', '=', 'tipomascotaid')
        ->join('unidads', 'unidads.id', '=', 'unidadid')
        ->select(mascota::raw('mascotas.id, tipomascotanombre, mascotaraza, mascotanombre, mascotaedad' ))
        ->where('unidads.id', $id)
        ->get();

        $act_residentes = 'active'; $act_vehiculos = ''; $act_mascotas = '';
        return view('admin.unidad.edit', compact('unidad', 'estados','propietario', 'bloques', 'bloqueid', 'tipo_unidads','clase_unidads','tipo_propietarios','parqueaderos','residentes','vehiculos','mascotas', 'act_residentes', 'act_vehiculos', 'act_mascotas'));

    }

    public function update(Request $request, Unidad $unidad)
    {

        $unidad->update([
            'propietarioid'=>null,
        ]);

        $validar_update = $unidad->id > 0 ? $unidad->id : "NULL";
        $request->validate([
            'bloqueid'=>'required',
            'unidadnombre'=>'required',
            'claseunidadid'=>'required',
            'estado_id' => 'required',
            'unidadnombre' => 'unique:unidads,unidadnombre,'.$validar_update.',id,bloqueid,' . $request->get('bloqueid')
        ]);
        //$unidad->update($request->all());

        $unidad->update([
            'bloqueid'=>$request->get('bloqueid'),
            'tipopropietarioid'=>$request->get('tipopropietarioid'),
            'propietarioid'=>$request->get('propietarioid'),
            'unidadnombre'=>$request->get('unidadnombre'),
            'claseunidadid'=>$request->get('claseunidadid'),
            'estado_id'=>$request->get('estado_id'),
        ]);

        $registro = Registro::whereUnidadid($unidad->id);
        $registro->update([
            'estado_id' => $request->get('estado_id'),
        ]);

        $user = User::join('residentes','residentes.personaid','users.personaid')
                ->join('registros','registros.unidadid','residentes.unidadid')
                ->where('residentes.unidadid','=',$unidad->id)
                ->select('users.id','registros.personaid')
                ->first();
        if($request->get('estado_id') == 4){
            $user->roles()->sync(5);
            //$user->assignRole($request->rol);
        }else{
            $user->roles()->sync(1);
        }

        $unidad->parqueaderos()->sync($request->parqueaderos);
        return redirect()->route('admin.unidads.edit', $unidad->id )->with('info','La unidad fue actualizada de forma exitosa');
    }

    public function destroy($id)
    {
        $unidad = Unidad::find($id);
        if(count($unidad->residentes)){
            return redirect()->route('admin.unidads.show', $unidad->bloqueid)->with('error','La unidad no se puede eliminar ya que contiene residentes');
        }
        if(count($unidad->vehiculos)){
            return redirect()->route('admin.unidads.show', $unidad->bloqueid)->with('error','La unidad no se puede eliminar ya que contiene vehiculos');
        }
        if(count($unidad->mascotas)){
            return redirect()->route('admin.unidads.show', $unidad->bloqueid)->with('error','La unidad no se puede eliminar ya que contiene mascotas');
        }
        $unidad->delete();
        return redirect()->route('admin.unidads.show', $unidad->bloqueid)->with('info','La unidad fue eliminada exitosamente');
    }
}
