<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Conjunto;

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

            $conjuntos = Conjunto::leftjoin("bloques","bloques.conjuntoid", "=", "conjuntos.id")
            ->join("barrios","barrios.id", "=", "conjuntos.barrioid")
            ->join("ciudads","ciudads.id", "=", "barrios.ciudadid")
            ->select(conjunto::raw('count(bloques.id) as bloque_count, conjuntos.id, conjuntos.barrioid, ciudadnombre, barrionombre, conjuntonombre, conjuntologo, conjuntodireccion, conjuntocorreo, conjuntocorreoconsejo, conjuntocorreocomite, conjuntocelular, conjuntotelefono, conjuntoestado'))
            ->whereIn('conjuntos.id', session('dependencias'))
            ->groupBy('conjuntos.id', 'conjuntos.barrioid', 'ciudadnombre', 'barrios.barrionombre', 'conjuntonombre', 'conjuntologo', 'conjuntodireccion','conjuntocorreo','conjuntocorreoconsejo', 'conjuntocorreocomite', 'conjuntocelular', 'conjuntotelefono', 'conjuntoestado')
            ->orderBy('bloque_count', 'DESC')
            ->get();

             return view('admin.conjunto.index')->with('conjuntos', $conjuntos);
    }
}
