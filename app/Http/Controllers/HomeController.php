<?php

namespace App\Http\Controllers;

use App\Models\Conjunto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        //$this->middleware('can:admin.index')->only('index');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $personaid = Auth::user()->personaid;
            $dependencias = Conjunto::select(['conjuntos.id'])
            ->join('persona_conjuntos', 'conjuntos.id', '=', 'persona_conjuntos.conjunto_id')
            ->whereRaw('persona_conjuntos.persona_id = ' . $personaid)
            ->get();

            if(count($dependencias) >= 1) {
                foreach ($dependencias as $dependencia){
                    $dep[] = $dependencia->id;
                }
                //session(['dependencias'=>$dep]);
            }else{
                $dep[] = 0;
                //session(['dependencias'=>$dep]);
            }

            $conjuntos = Conjunto::leftjoin("bloques","bloques.conjuntoid", "=", "conjuntos.id")
            ->join("barrios","barrios.id", "=", "conjuntos.barrioid")
            ->join("ciudads","ciudads.id", "=", "barrios.ciudadid")
            ->select(conjunto::raw('count(bloques.id) as bloque_count, conjuntos.id, conjuntos.barrioid, ciudadnombre, barrionombre, conjuntonombre, conjuntologo, conjuntodireccion, conjuntocelular, conjuntotelefono, conjuntoestado'))
            ->whereIn('conjuntos.id', $dep)
            ->groupBy('conjuntos.id', 'conjuntos.barrioid', 'ciudadnombre', 'barrios.barrionombre', 'conjuntonombre', 'conjuntologo', 'conjuntodireccion', 'conjuntocelular', 'conjuntotelefono', 'conjuntoestado')
            ->orderBy('bloque_count', 'DESC')
            ->pluck('conjuntonombre', 'conjuntos.id');

            if($conjuntos->count()){
                if($conjuntos->count()>1){
                    return view('vendor.adminlte.auth.passwords.rol')->with('conjuntos', $conjuntos);
                }else{
                    session(['dependencias'=>$dep]);
                    return redirect()->route('admin.index');
                }
            }

            return redirect()->route('login');

    }

    public function show(Request $request){
        $dep[] = $request->get('conjuntoid');
        session(['dependencias'=>$dep]);

        return redirect()->route('admin.index');

    }
}
