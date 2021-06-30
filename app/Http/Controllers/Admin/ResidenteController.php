<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Residente;
use App\Models\Unidad;
use App\Models\TipoDocumento;
use App\Models\Conjunto;
use App\Models\TipoResidente;
use App\Models\Persona;
use App\Models\Relation;
use App\Models\User;

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
        $conjuntos = Conjunto::whereIn('conjuntos.id', session('dependencias'))->pluck('conjuntonombre', 'id');

        $unidads = Unidad::join('bloques','bloques.id','=','unidads.bloqueid')
            ->select(
            Unidad::raw("CONCAT(bloquenombre,' - ',unidadnombre) AS unidad"),'unidads.id')
            ->where('unidads.id', '=', $id)
            ->whereIn('conjuntoid', session('dependencias'))
            ->orderBy('unidad','ASC')
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
            'personadocumento'=>'required',
            'personanombre'=>'required',
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

            $user = User::create([
                'name' => $request->get('personanombre'),
                'email' => $request->get('personacorreo'),
                'password' => bcrypt($request->get('password'))
            ]);
        }

        if (!Residente::where('personaid', '=', $persona->id)->exists()) {
            Residente::create([
                'personaid'=>$persona->id,
                'unidadid'=>$request->get('unidadid'),
                'tiporesidenteid'=>$request->get('tiporesidenteid'),
                'relationid'=>$request->get('relationid'),
            ]);
        }

        $persona->conjuntos()->sync($request->conjuntos);
        $user->roles()->sync(5);

        if(!$request->get('residentes'))
            return redirect()->route('admin.residentes.index')->with('info','El residente fue agregado de forma exitosa');
        else
        return redirect()->route('admin.unidads.edit', $request->get('unidadid'))->with('info','El residente fue agregado de forma exitosa');
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

        // $user = User::wherePersonaid($residente->personaid)->first();
        // $user->roles()->sync(5);

        return redirect()->route('admin.residentes.index')->with('info','El residente fue actualizado de forma exitosa');

    }

    public function destroy(Request $request, $id)
    {
        $residente = Residente::find($id);
        $residente->delete();

        if(!$request->get('residentes'))
            return redirect()->route('admin.residentes.show', $residente->unidadid)->with('info','El residente fue eliminado exitosamente');
        else
            return redirect()->route('admin.unidads.edit', $residente->unidadid)->with('info','El residente fue eliminado exitosamente');
    }
}
