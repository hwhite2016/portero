<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\WelcomeMailable;
use App\Models\Conjunto;
use App\Models\Empleado;
use App\Models\Persona;
use App\Models\TipoDocumento;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;

class EmpleadoController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('can:admin.empleados.index')->only('index');
        $this->middleware('can:admin.empleados.create')->only('create', 'store');
        $this->middleware('can:admin.empleados.edit')->only('edit', 'update');
        $this->middleware('can:admin.empleados.destroy')->only('destroy');
    }

    public function index()
    {
        $empleados = Empleado::join('conjuntos','conjuntos.id','=','empleados.conjuntoid')
             ->join('personas','personas.id','=','empleados.personaid')
             ->join('roles','roles.id','=','empleados.role_id')
             ->select('empleados.id', 'conjuntonombre', 'personadocumento', 'personanombre', 'personacorreo', 'personacelular', 'roles.name', 'empleadoestado')
             ->whereIn('conjuntos.id', session('dependencias'))
             ->orderBy('personanombre', 'ASC')
             ->get();
             return view('admin.empleado.index')->with('empleados', $empleados);
    }

    public function create(Request $request)
    {
        $user = User::find(Auth::user()->id);

        $tipo_documentos = TipoDocumento::all()->pluck('tipodocumentonombre', 'id');
        if ($user->hasRole('_superadministrador')) $roles = Role::orderBy('name','ASC')->pluck('name', 'id');
        if ($user->hasRole('_administrador')) $roles = Role::where('id','!=',5)->whereRaw("SUBSTR(name,1,1) != '_'")->orderBy('name','ASC')->pluck('name', 'id');

        $conjuntos = Conjunto::whereIn('conjuntos.id', session('dependencias'))->pluck('conjuntonombre', 'id');

        return view('admin.empleado.create', compact('tipo_documentos', 'roles', 'conjuntos'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'conjuntoid'=>'required',
            'role_id'=>'required',
            'tipodocumentoid'=>'required',
            'personadocumento'=>'required|min:3|alpha_num',
            'personanombre'=>'required|min:3',
            'personacorreo'=>'required|email',
        ]);
        if (Persona::where('personadocumento', '=', $request->get('personadocumento'))->exists()) {
            $persona = Persona::where('personadocumento','=',$request->get('personadocumento'))->first();
        }else{
            $request->validate([
                'personacorreo'=>'unique:personas',
            ]);
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

            $psswd = substr( md5(microtime()), 1, 10);
            $user = User::create([
                'personaid' => $persona->id,
                'name' => $request->get('personanombre'),
                'email' => $request->get('personacorreo'),
                'password' => bcrypt($psswd)
            ]);

            if ($request->get('bienvenida') == 1){
                $data = [
                    'role_id' => $request->get('role_id'),
                    'name' => $request->get('personanombre'),
                    'email' => $request->get('personacorreo'),
                    'password' => $psswd
                ];
                $correo = new WelcomeMailable($data);
                Mail::to('kimita0627@gmail.com')->send($correo);
            }
        }

        if (!Empleado::where('personaid', '=', $persona->id)->whereConjuntoid($request->get('conjuntoid'))->exists()) {
            Empleado::create([
                'personaid'=>$persona->id,
                'conjuntoid'=>$request->get('conjuntoid'),
                'role_id'=>$request->get('role_id'),
                'empleadoestado'=>$request->get('empleadoestado'),
            ]);

            //$persona->conjuntos()->sync($request->conjuntoid);
            $persona->conjuntos()->detach($request->conjuntoid);
            $persona->conjuntos()->attach($request->conjuntoid);
            if($request->get('empleadoestado') == 1){
                $user->assignRole($request->role_id);
            }
            return redirect()->route('admin.empleados.index')->with('info','El empleado fue agregado de forma exitosa');
        }

        return redirect()->route('admin.empleados.index')->with('error','El registro no fue creado, El empleado ya hace parte de la copropiedad');

    }

    public function show($id)
    {
        $empleados = Empleado::join('conjuntos','conjuntos.id','=','empleados.conjuntoid')
             ->join('personas','personas.id','=','empleados.personaid')
             ->join('roles','roles.id','=','empleados.role_id')
             ->select('empleados.id', 'conjuntonombre', 'personadocumento', 'personanombre', 'personacorreo', 'personacelular', 'roles.name', 'empleadoestado')
             ->where('conjuntos.id', $id)
             ->whereIn('conjuntos.id', session('dependencias'))
             ->orderBy('personanombre', 'ASC')
             ->get();

        return view('admin.empleado.index', compact('empleados'));
    }

    public function edit($id)
    {
        $empleado = Empleado::find($id);
        $user = User::find(Auth::user()->id);

        if ($user->hasRole('_superadministrador')) $roles = Role::all()->pluck('name', 'id');
        if ($user->hasRole('_administrador')) $roles = Role::whereRaw("SUBSTR(name,1,1) != '_'")->pluck('name', 'id');
        $conjuntos = Conjunto::whereIn('conjuntos.id', session('dependencias'))->pluck('conjuntonombre', 'id');

        //$unidads->prepend('Seleccione la unidad', '');
        $persona = Persona::where('id', $empleado->personaid)->get();

        return view('admin.empleado.edit', compact('empleado', 'persona', 'roles', 'conjuntos'));

    }

    public function update(Request $request, Empleado $empleado)
    {
        $request->validate([
            'conjuntoid'=>'required',
            'role_id'=>'required'
        ]);

        $empleado->update([
            'conjuntoid'=>$request->get('conjuntoid'),
            'role_id'=>$request->get('role_id'),
            'empleadoestado'=>$request->get('empleadoestado'),
        ]);

        $persona = Persona::whereId($empleado->personaid)->first();
        $user = User::wherePersonaid($empleado->personaid)->first();

        //$user = User::wherePersonaid($residente->personaid)->first();
        //$user->assignRole($request->rol);

        //$persona->conjuntos()->detach($request->conjuntoid);
        //$persona->conjuntos()->attach($request->conjuntoid);
        if($request->get('empleadoestado') == 1){
            if(!$user->hasRole($request->get('role_id')))  $user->syncRoles($request->role_id);
        }else{
            $user->syncRoles($request->role_id);
            $user->removeRole($request->get('role_id'));
        }

        return redirect()->route('admin.empleados.index')->with('info','El empleado fue actualizado de forma exitosa');

    }

    public function destroy(Request $request, $id)
    {
        $remover_rol = false;
        $remover_conjunto = false;
        $conjunto = Empleado::select('empleados.id', 'conjuntoid')
            ->where('empleados.id', $id)
            ->first();

        $empleado = Empleado::find($id);
        $empleado->delete();

        $user_rol = User::where('users.personaid', $empleado->personaid)
            ->select('empleados.id as empleado_id', 'users.id as user_id', 'users.personaid as persona id', 'users.name', 'empleados.conjuntoid')
            ->join('empleados', 'empleados.personaid', 'users.personaid')
            ->get();

        $user_conjunto = User::where('users.personaid', $empleado->personaid)
            ->select('empleados.id as empleado_id', 'users.id as user_id', 'users.personaid as persona id', 'users.name', 'empleados.conjuntoid')
            ->join('empleados', 'empleados.personaid', 'users.personaid')
            ->where('empleados.conjuntoid', '=', $conjunto->conjuntoid)
            ->get();

        if($user_rol->count() <= 0) $remover_rol = true;
        if($user_conjunto->count() <= 0) $remover_conjunto = true;

        if ($remover_rol){
            $user = User::where('users.personaid', $empleado->personaid)->first();
            $user->removeRole($empleado->role_id);
        }

        if ($remover_conjunto){
            $persona = Persona::where('id', $empleado->personaid)->first();
            $persona->conjuntos()->detach($conjunto->conjuntoid);
            //$persona->removeConjunto($request->conjuntoid);
        }

        //return $user;

        return redirect()->route('admin.empleados.show', $empleado->conjuntoid)->with('info','El empleado fue eliminado exitosamente');

    }
}
