<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Conjunto;
use App\Models\Empleado;
use App\Models\Organo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrganoController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('can:admin.organos.index')->only('index');
        $this->middleware('can:admin.organos.create')->only('create', 'store');
        $this->middleware('can:admin.organos.edit')->only('edit', 'update');
        $this->middleware('can:admin.organos.destroy')->only('destroy');
    }

    public function index()
    {

        $organos = Organo::leftJoin('empleados', function ($join) {
                $join->on('empleados.organo_id', '=', 'organos.id')
                ->where('empleadoestado', '>', -1);
            })
            ->select('organos.id','organonombre','organocorreo', 'organocelular', 'organotelefono', 'organopqr', 'organoestado',
                    DB::raw('count(empleados.id) as emp_count'))
            ->whereIn('organos.conjuntoid', session('dependencias'))
            ->GroupByRaw('organos.id,organonombre,organocorreo,organocelular,organotelefono,organopqr,organoestado')
            ->get();

        return view('admin.organo.index', compact('organos'));
    }

    public function estructura()
    {
        $conjunto = Conjunto::whereIn('id', session('dependencias'))->first();

        $colaboradores = Organo::join('empleados','organos.id','=','empleados.organo_id')
             ->join('cargos','cargos.id','=','empleados.cargo_id')
             ->join('personas','personas.id','=','empleados.personaid')
             ->leftJoin('residentes','residentes.personaid','=','empleados.personaid')
             ->leftJoin('unidads','unidads.id','=','residentes.unidadid')
             ->select('organos.id','organonombre','organocorreo', 'organocelular', 'organotelefono', 'organopqr', 'organonivel',
                DB::raw("JSON_OBJECTAGG(coalesce(concat(cargonombre,' | ',personanombre),0), coalesce(unidadnombre,'') ) AS miembros"))
             ->whereIn('empleados.conjuntoid', session('dependencias'))
             ->GroupByRaw('organos.id,organonombre,organocorreo,organocelular,organotelefono,organopqr,organonivel')
             ->orderBy('organonombre', 'ASC')
             ->get();


        return view('admin.estructura.index', compact('conjunto','colaboradores'));
    }

    public function create()
    {
        $conjuntos = Conjunto::whereIn('id', session('dependencias'))->pluck('conjuntonombre', 'id');

        return view('admin.organo.create', compact('conjuntos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'conjuntoid'=>'required',
            'organonombre'=>'required',
            'organocorreo'=>'required|email'
        ]);

        Organo::create($request->all());

        return redirect()->route('admin.organos.index')->with('info','El organo de control fue agregado de forma exitosa');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $organo = Organo::find($id);
        $conjuntos = Conjunto::whereIn('id', session('dependencias'))->pluck('conjuntonombre', 'id');

        return view('admin.organo.edit', compact('conjuntos', 'organo'));
    }

    public function update(Request $request, Organo $organo)
    {
        $user = User::find(Auth::user()->id);
        $request->validate([
            'conjuntoid'=>'required',
            'organocorreo'=>'required|email'
        ]);

        if ($user->hasRole('_superadministrador')){
            $organo->update($request->all());
        }else{
            $organo->update([
                'organocorreo' => $request->get('organocorreo'),
                'organocelular' => $request->get('organocelular'),
                'organotelefono' => $request->get('organotelefono'),
            ]);
        }

        return redirect()->route('admin.organos.index')->with('info','El organo de control fue actualizado de forma exitosa');

    }

    public function destroy($id)
    {

        $organo = Organo::find($id);
        $organo->delete();
        return redirect()->route('admin.organos.index')->with('info','El organo de control fue eliminado exitosamente');
    }

}
