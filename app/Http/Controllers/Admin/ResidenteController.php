<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bloque;
use Illuminate\Http\Request;
use illuminate\Database\Eloquent\Collection;
use App\Models\Residente;
use App\Models\Unidad;
use App\Models\TipoDocumento;
use App\Models\Conjunto;
use App\Models\TipoResidente;
use App\Models\Persona;
use App\Models\Relation;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ResidenteController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('can:admin.residentes.index')->only('index');
        $this->middleware('can:admin.residentes.create')->only('create', 'store');
        $this->middleware('can:admin.residentes.edit')->only('edit', 'update');
        $this->middleware('can:admin.residentes.destroy')->only('destroy');
    }

    public function index()
    {
        $residentes = Residente::join("unidads","unidads.id", "=", "residentes.unidadid")
             ->join('bloques','bloques.id','=','unidads.bloqueid')
             ->join('conjuntos','conjuntos.id','=','bloques.conjuntoid')
             ->join('personas','personas.id','=','residentes.personaid')
             ->join('tipo_residentes','tipo_residentes.id','=','residentes.tiporesidenteid')
             ->join('relations','relations.id','=','residentes.relationid')
             ->select(Residente::raw('residentes.id, conjuntonombre, bloquenombre, unidadnombre, personanombre, personacorreo, personacelular, tiporesidenteid, tiporesidentenombre, relationname'))
             ->whereIn('conjuntos.id', session('dependencias'))
             ->orderBy('personanombre', 'ASC')
             ->get();
             return view('admin.residente.index')->with('residentes', $residentes);
    }

    public function list()
    {
        $unidades = Unidad::join('bloques','bloques.id','=','unidads.bloqueid')
             ->join('conjuntos','conjuntos.id','=','bloques.conjuntoid')
             ->join('residentes','unidads.id','=','residentes.unidadid')
             ->leftJoin('vehiculos','unidads.id','=','vehiculos.unidadid')
             ->leftJoin('tipo_vehiculos','tipo_vehiculos.id','=','vehiculos.tipovehiculoid')
             ->join('personas','personas.id','=','residentes.personaid')
             ->join('tipo_residentes','tipo_residentes.id','=','residentes.tiporesidenteid')
             ->select('conjuntonombre','bloquenombre','unidadnombre', DB::raw("JSON_OBJECTAGG(concat(personadocumento,' - ', personanombre), tiporesidentenombre) AS residentes"), DB::raw("JSON_OBJECTAGG(coalesce(tipovehiculonombre,0), coalesce(vehiculoplaca,0)) AS vehiculos"))
             ->whereIn('conjuntos.id', session('dependencias'))
             ->GroupByRaw('conjuntonombre, bloquenombre, unidadnombre')
             ->orderBy('bloquenombre', 'ASC')
             ->orderBy('unidadnombre', 'ASC')
             ->get();
        //return $unidades;

        return view('admin.residente.list')->with('unidades', $unidades);
    }

    public function create(Request $request)
    {
        $tipo_documentos = TipoDocumento::all()->pluck('tipodocumentonombre', 'id');
        $tipo_residentes = TipoResidente::all()->pluck('tiporesidentenombre', 'id');
        $relations = Relation:: all()->pluck('relationname', 'id');
        $conjuntos = Conjunto::whereIn('conjuntos.id', session('dependencias'))->pluck('conjuntonombre', 'id');

        $unidads = Unidad::join('bloques','bloques.id','=','unidads.bloqueid')
            ->select(
            Unidad::raw("CONCAT(bloquenombre,' - ',unidadnombre) AS unidad"),'unidads.id')
            ->whereIn('conjuntoid', session('dependencias'))
            ->orderBy('unidad','ASC')
            ->pluck('unidad', 'unidads.id');

        //$unidads->prepend('Seleccione la unidad', '');

        return view('admin.residente.create', compact('tipo_documentos', 'tipo_residentes', 'relations', 'conjuntos', 'unidads'));
    }

    public function createModal(Request $request, $id)
    {
        $tipo_documentos = TipoDocumento::all()->pluck('tipodocumentonombre', 'id');
        $tipo_residentes = TipoResidente::all()->pluck('tiporesidentenombre', 'id');
        $relations = Relation:: all()->pluck('relationname', 'id');

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

        return view('admin.residente.createModal', compact('tipo_documentos', 'tipo_residentes', 'relations', 'conjuntos', 'unidads'));

    }


    public function store(Request $request)
    {
        $request->validate([
            'conjuntoid'=>'required',
            'unidadid'=>'required',
            'tipodocumentoid'=>'required',
            'personadocumento'=>'required|min:3|alpha_num',
            'personanombre'=>'required|min:3',
            'personacorreo'=>'required|email',
            'unidadid' => 'unique:residentes,unidadid,NULL,id,personaid,' . $request->get('personaid')
        ]);
        if (Persona::where('personadocumento', '=', $request->get('personadocumento'))->exists()) {
            $persona = Persona::where('personadocumento','=',$request->get('personadocumento'))->first();
        }else{

            $persona = Persona::create([
                'tipodocumentoid'=>$request->get('tipodocumentoid'),
                'personadocumento'=>$request->get('personadocumento'),
                'personanombre'=>$request->get('personanombre'),
                'personacelular'=>$request->get('personacelular'),
                'personacorreo'=>$request->get('personacorreo'),
                'personafechanacimiento'=>str_replace("/", "", $request->get('personafechanacimiento')),
             ]);
        }

        if (User::where('personaid', '=', $persona->id)->exists()) {
            $user = User::where('personaid','=',$persona->id)->first();
        }else{

            $psswd = substr( md5(microtime()), 1, 8);
            $user = User::create([
                'personaid' => $persona->id,
                'name' => $request->get('personanombre'),
                'email' => $request->get('personacorreo'),
                'password' => bcrypt($psswd)
            ]);
        }

        if (Unidad::where('id', '=', $request->get('unidadid'))->exists()) {
            $unidad= Unidad::where('id','=',$request->get('unidadid'))->first();
            $unidad->update([
                'propietarioid'=>$persona->id,
            ]);
        }

        if($request->get('tiporesidenteid')){
            if (!Residente::where('personaid', '=', $persona->id)->whereUnidadid($request->get('unidadid'))->exists()) {
                Residente::create([
                    'personaid'=>$persona->id,
                    'unidadid'=>$request->get('unidadid'),
                    'tiporesidenteid'=>$request->get('tiporesidenteid'),
                    'relationid'=>$request->get('relationid'),
                ]);
            }
        }

        //$persona->conjuntos()->sync($request->conjuntoid);
        $persona->conjuntos()->detach($request->conjuntoid);
        $persona->conjuntos()->attach($request->conjuntoid);
        $user->assignRole($request->rol);
        //$user->roles()->sync($request->rol);

        if(!$request->get('residentes')){

            return redirect()->route('admin.residentes.index')->with('info','El residente fue agregado de forma exitosa');
        }else{
            return redirect()->route('admin.unidads.edit', $request->get('unidadid'))->with('info','El residente fue agregado de forma exitosa');
        }
    }

    public function show($id)
    {
        $residentes = Residente::join("unidads","unidads.id", "=", "residentes.unidadid")
        ->join('bloques','bloques.id','=','unidads.bloqueid')
        ->join('conjuntos','conjuntos.id','=','bloques.conjuntoid')
        ->join('personas','personas.id','=','residentes.personaid')
        ->join('relations','relations.id','=','residentes.relationid')
        ->join('tipo_residentes','tipo_residentes.id','=','residentes.tiporesidenteid')
        ->select(Residente::raw('residentes.id, conjuntonombre, bloquenombre, unidadnombre, personanombre, personacorreo, personacelular, tiporesidenteid, tiporesidentenombre, relationname'))
        ->where('unidads.id', $id)
        ->whereIn('conjuntos.id', session('dependencias'))
        ->orderBy('personanombre', 'ASC')
        ->get();
        return view('admin.residente.index', compact('residentes'));
    }

    public function edit($id)
    {
        $residente = Residente::find($id);
        $tipo_residentes = TipoResidente::all()->pluck('tiporesidentenombre', 'id');
        $relations = Relation:: all()->pluck('relationname', 'id');
        $conjuntos = Conjunto::whereIn('conjuntos.id', session('dependencias'))->pluck('conjuntonombre', 'id');
        $unidads = Unidad::join('bloques','bloques.id','=','unidads.bloqueid')
            ->select(
            Unidad::raw("CONCAT(bloquenombre,' - ',unidadnombre) AS unidad"),'unidads.id')
            ->whereIn('conjuntoid', session('dependencias'))
            ->orderBy('unidad','ASC')
            ->pluck('unidad', 'unidads.id');

        //$unidads->prepend('Seleccione la unidad', '');
        $persona = Persona::where('id', $residente->personaid)->get();

        return view('admin.residente.edit', compact('residente', 'persona', 'tipo_residentes', 'relations', 'conjuntos', 'unidads'));

    }

    public function update(Request $request, Residente $residente)
    {
        $request->validate([
            'conjuntoid'=>'required',
            'unidadid'=>'required'
        ]);

        $residente->update([
            'unidadid'=>$request->get('unidadid'),
            'tiporesidenteid'=>$request->get('tiporesidenteid'),
            'relationid'=>$request->get('relationid'),
        ]);

        //$user = User::wherePersonaid($residente->personaid)->first();
        //$user->assignRole($request->rol);

        return redirect()->route('admin.residentes.index')->with('info','El residente fue actualizado de forma exitosa');

    }

    public function destroy(Request $request, $id)
    {
        $remover_rol = false;
        $remover_conjunto = false;
        $conjunto = Residente::join('unidads', 'unidads.id', 'residentes.unidadid')
            ->join('bloques', 'bloques.id', 'unidads.bloqueid')
            ->select('residentes.id', 'unidadnombre', 'bloques.conjuntoid')
            ->where('residentes.id', $id)
            ->first();

        $residente = Residente::find($id);
        $residente->delete();

        $user_rol = User::where('users.personaid', $residente->personaid)
            ->select('residentes.id as residente_id', 'users.id as user_id', 'users.personaid as persona id', 'users.name', 'residentes.unidadid')
            ->join('residentes', 'residentes.personaid', 'users.personaid')
            ->get();

        $user_conjunto = User::where('users.personaid', $residente->personaid)
            ->select('residentes.id as residente_id', 'users.id as user_id', 'users.personaid as persona id', 'users.name', 'residentes.unidadid','conjuntoid')
            ->join('residentes', 'residentes.personaid', 'users.personaid')
            ->join('unidads', 'unidads.id', 'residentes.unidadid')
            ->join('bloques', 'bloques.id', 'unidads.bloqueid')
            ->where('bloques.conjuntoid', '=', $conjunto->conjuntoid)
            ->get();

        if($user_rol->count() <= 0) $remover_rol = true;
        if($user_conjunto->count() <= 0) $remover_conjunto = true;

        if ($remover_rol){
            $user = User::where('users.personaid', $residente->personaid)->first();
            $user->removeRole('Residente');
        }

        if ($remover_conjunto){
            $persona = Persona::where('id', $residente->personaid)->first();
            $persona->conjuntos()->detach($conjunto->conjuntoid);
            //$persona->removeConjunto($request->conjuntoid);
        }

        //return $user;

        //$user->removeRole($user->roles->first());
        //$user->roles()->sync();
        //$user->syncRoles($roles);

        // $user->roles()->sync($request->rol);

        if(!$request->get('residentes'))
            return redirect()->route('admin.residentes.show', $residente->unidadid)->with('info','El residente fue eliminado exitosamente');
        else
            return redirect()->route('admin.unidads.edit', $residente->unidadid)->with('info','El residente fue eliminado exitosamente');
    }
}
