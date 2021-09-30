<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Conjunto;
use App\Models\Empleado;
use Illuminate\Http\Request;

class OrganoController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('can:admin.organos.index')->only('index');
    }

    public function index()
    {
        $conjunto = Conjunto::where('id', session('dependencias'))->first();

        $colaboradores = Empleado::join('cargos','cargos.id','=','empleados.cargo_id')
             ->join('personas','personas.id','=','empleados.personaid')
             ->leftJoin('residentes','residentes.personaid','=','empleados.personaid')
             ->leftJoin('unidads','unidads.id','=','residentes.unidadid')
             ->select('empleados.id', 'personanombre', 'unidadnombre', 'cargonombre', 'cargonivel','empleadoestado')
             ->whereIn('empleados.conjuntoid', session('dependencias'))
             ->orderBy('cargos.id', 'ASC')
             ->get();

        return view('admin.organo.index', compact('conjunto','colaboradores'));
    }

}
