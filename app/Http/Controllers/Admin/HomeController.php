<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Anuncio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Conjunto;
use App\Models\Organo;
use App\Models\Registro;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('can:admin.index')->only('index');

    }

    public function index(Request $request){
        // $personaid = Auth::user()->personaid;
        //     $dependencias = Conjunto::select(['conjuntos.id'])
        //     ->join('persona_conjuntos', 'conjuntos.id', '=', 'persona_conjuntos.conjunto_id')
        //     ->whereRaw('persona_conjuntos.persona_id = ' . $personaid)
        //     ->whereRaw('persona_conjuntos.conjunto_id = ' . $request->get('conjuntoid'))
        //     ->get();

        //     if(count($dependencias) >= 1) {
        //         foreach ($dependencias as $dependencia){
        //             $dep[] = $dependencia->id;
        //         }
        //         session(['dependencias'=>$dep]);
        //     }else{
        //         $dep[] = 0;
        //         session(['dependencias'=>$dep]);
        //     }

        $organos = Organo::whereOrganoestado(1)->whereIn('conjuntoid', session('dependencias'))->orderBy('organonombre', 'ASC')->get();

        $conjuntos = Conjunto::leftjoin("bloques","bloques.conjuntoid", "=", "conjuntos.id")
            ->join("barrios","barrios.id", "=", "conjuntos.barrioid")
            ->join("ciudads","ciudads.id", "=", "barrios.ciudadid")
            ->select(conjunto::raw('count(bloques.id) as bloque_count, conjuntos.id, conjuntos.barrioid, ciudadnombre, barrionombre, conjuntonombre, conjuntologo, conjuntodireccion, conjuntocelular, conjuntotelefono, conjuntoestado'))
            ->whereIn('conjuntos.id', session('dependencias'))
            ->groupBy('conjuntos.id', 'conjuntos.barrioid', 'ciudadnombre', 'barrios.barrionombre', 'conjuntonombre', 'conjuntologo', 'conjuntodireccion', 'conjuntocelular', 'conjuntotelefono', 'conjuntoestado')
            ->orderBy('bloque_count', 'DESC')
            ->get();

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

            $comunicados = Anuncio::join('tipo_anuncios', 'tipo_anuncios.id', 'anuncios.tipoanuncioid')
            ->select('tipoanuncionombre','anuncionombre','anuncios.created_at')
            ->latest()->take(5)->get();

             return view('admin.conjunto.index', compact('conjuntos','organos', 'colaboradores', 'comunicados'));
    }
}
