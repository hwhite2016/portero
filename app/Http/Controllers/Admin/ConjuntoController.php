<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Anuncio;
use App\Models\Conjunto;
use App\Models\Barrio;
use App\Models\Ciudad;
use App\Models\Organo;
use App\Models\Pais;
use App\Models\Registro;
use App\Models\TipoDocumento;
use App\Models\TipoPropietario;
use App\Models\User;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConjuntoController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('can:admin.conjuntos.index')->only('index');
        $this->middleware('can:admin.conjuntos.create')->only('create', 'store');
        $this->middleware('can:admin.conjuntos.edit')->only('edit', 'update');
        $this->middleware('can:admin.conjuntos.destroy')->only('destroy');

    }

    public function index()
    {

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
             ->select('conjuntoid','anuncios.id','tipoanuncioid','tipoanuncionombre','anuncionombre','anuncioadjunto','anunciofechaentrega','anuncios.created_at','anuncios.updated_at')
             ->whereAnuncioestado(1)
             ->whereBloqueid(NULL)
             ->latest()->take(10)
             ->get();

            return view('admin.conjunto.index', compact('conjuntos','organos', 'colaboradores', 'comunicados'));

    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
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

            $organos = Organo::whereOrganoestado(1)->whereIn('conjuntoid', session('dependencias'))->orderBy('organonombre', 'ASC')->get();

            $conjuntos = Conjunto::leftjoin("bloques","bloques.conjuntoid", "=", "conjuntos.id")
            ->join("barrios","barrios.id", "=", "conjuntos.barrioid")
            ->join("ciudads","ciudads.id", "=", "barrios.ciudadid")
            ->select(conjunto::raw('count(bloques.id) as bloque_count, conjuntos.id, conjuntos.barrioid, ciudadnombre, barrionombre, conjuntonombre, conjuntologo, conjuntodireccion, conjuntocelular, conjuntotelefono, conjuntoestado'))
            ->where('conjuntos.barrioid', '=', $id)
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

        return view('admin.conjunto.index', compact('conjuntos','organos','colaboradores'));
    }

    public function edit(Conjunto $conjunto)
    {
        $this->authorize('administrador', $conjunto);

        $organos = Organo::whereIn('conjuntoid', session('dependencias'))->get();
        $barrios = Barrio::all()->pluck('barrionombre', 'id');
        return view('admin.conjunto.edit', compact('conjunto','barrios','organos'));
    }

   public function update(Request $request, Conjunto $conjunto)
    {
        $this->authorize('administrador', $conjunto);

        //$conjunto = Conjunto::find($id);
        $request->validate([
            'conjuntonit'=>'required',
         ]);

        if ($request->hasfile('conjuntologo')){
           $this->validate($request, [
               'conjuntologo' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',
           ]);
           $destinationPath = public_path('/storage');
           $file = $request->file('conjuntologo');
           $filename = 'logos/'.date('YmdHis').'.'.$file->getClientOriginalExtension();
           $fullpath_old = $destinationPath.'/'.$conjunto->conjuntologo;
           //\Storage::disk('public')->put($filename,  \File::get($file));
           Image::make($file->getRealPath())->resize(700, 390, function ($constraint) {
           $constraint->aspectRatio();})->save($destinationPath.'/'.$filename);
           if((File::exists($fullpath_old)) && ($conjunto->conjuntologo <> 'images/yourlogo.png')) {
                File::delete($fullpath_old);
           }
            $conjunto->conjuntologo = $filename;
        }

        $conjunto->conjuntonit = $request->get('conjuntonit');
        $conjunto->conjuntocelular = $request->get('conjuntocelular');
        $conjunto->conjuntotelefono = $request->get('conjuntotelefono');

        $conjunto->save();

        return redirect()->route('admin.conjuntos.show', $conjunto->barrioid)->with('info','El conjunto fue actualizado de forma exitosa');

    }

    public function destroy($id)
    {

        //
    }
}
