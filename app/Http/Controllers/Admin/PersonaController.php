<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Persona;
use App\Models\User;
use App\Models\TipoDocumento;
use App\Models\Conjunto;
use Spatie\Permission\Models\Role;

class PersonaController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('can:admin.personas.index')->only('index');
        $this->middleware('can:admin.personas.create')->only('create', 'store');
        $this->middleware('can:admin.personas.edit')->only('edit', 'update');
        $this->middleware('can:admin.personas.destroy')->only('destroy');
    }

    public function index()
    {
        $personas = Persona::orderBy('personanombre','ASC')->get();

        return view('admin.persona.index', compact('personas'));
    }

    public function create()
    {
        $tipo_documentos = TipoDocumento::all()->pluck('tipodocumentonombre', 'id');
        $conjuntos = Conjunto::all()->pluck('conjuntonombre', 'id');
        //$roles = Role::all()->pluck('name', 'id');
        $roles = Role::all();
        return view('admin.persona.create', compact('tipo_documentos', 'conjuntos', 'roles'));
    }

    public function store(Request $request)
    {
         $request->validate([
            'personanombre'=>'required|min:3',
            'personadocumento'=>'required|alpha_num',
            'conjuntos'=>'required'
         ]);
         $persona = Persona::create([
            'tipodocumentoid'=>$request->get('tipodocumentoid'),
            'personadocumento'=>$request->get('personadocumento'),
            'personanombre'=>$request->get('personanombre'),
            'personafechanacimiento'=>str_replace("/", "", $request->get('personafechanacimiento')),
            'personacorreo'=>$request->get('personacorreo'),
            'personacelular'=>$request->get('personacelular'),
         ]);

         $persona->conjuntos()->sync($request->conjuntos);

         if ($request->get('user') == 1){
            if (User::where('personaid', '=', $persona->get('id'))->exists()) {
                $user = User::where('personaid','=',$persona->id)->first();
            }else{

                $psswd = substr( md5(microtime()), 1, 8);
                $user = User::create([
                    'personaid' => $persona->get('id'),
                    'name' => $request->get('personanombre'),
                    'email' => $request->get('personacorreo'),
                    'password' => bcrypt($psswd)
                ]);
            }
            //$user = User::wherePersonaid($persona->id)->first();
            $user->roles()->sync($request->roles);
        }

        return redirect()->route('admin.personas.index')->with('info','La persona fue agregada de forma exitosa');
    }

    public function show()
    {
        //
    }

    public function edit($id)
    {
        $persona = Persona::find($id);
        $tipo_documentos = TipoDocumento::all()->pluck('tipodocumentonombre', 'id');
        $conjuntos = Conjunto::all()->pluck('conjuntonombre', 'id');

        return view('admin.persona.edit', compact('persona', 'tipo_documentos', 'conjuntos'));
    }

    public function update(Request $request, Persona $persona)
    {
        $request->validate([
            'personanombre'=>'required|min:3',
            'personadocumento'=>'required|min:3|alpha_num',
            'conjuntos'=>'required'
        ]);

        $persona->update([
            'tipodocumentoid'=>$request->get('tipodocumentoid'),
            'personadocumento'=>$request->get('personadocumento'),
            'personanombre'=>$request->get('personanombre'),
            'personafechanacimiento'=>str_replace("/", "", $request->get('personafechanacimiento')),
            'personacorreo'=>$request->get('personacorreo'),
            'personacelular'=>$request->get('personacelular'),
        ]);

        $persona->conjuntos()->sync($request->conjuntos);

         return redirect()->route('admin.personas.index')->with('info','La persona fue actualizada de forma exitosa');
    }

    public function destroy($id)
    {
        $persona = Persona::find($id);
        $persona->delete();
        return redirect()->route('admin.personas.index')->with('info','La persona fue eliminada exitosamente');

    }
}
