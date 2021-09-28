<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Conjunto;
use App\Models\Barrio;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

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

            $conjuntos = Conjunto::leftjoin("bloques","bloques.conjuntoid", "=", "conjuntos.id")
            ->join("barrios","barrios.id", "=", "conjuntos.barrioid")
            ->join("ciudads","ciudads.id", "=", "barrios.ciudadid")
            ->select(conjunto::raw('count(bloques.id) as bloque_count, conjuntos.id, conjuntos.barrioid, ciudadnombre, barrionombre, conjuntonombre, conjuntologo, conjuntodireccion, conjuntocorreo, conjuntocorreoconsejo, conjuntocorreocomite, conjuntocelular, conjuntotelefono, conjuntoestado'))
            ->where('conjuntos.barrioid', '=', $id)
            ->whereIn('conjuntos.id', session('dependencias'))
            ->groupBy('conjuntos.id', 'conjuntos.barrioid', 'ciudadnombre', 'barrios.barrionombre', 'conjuntonombre', 'conjuntologo', 'conjuntodireccion','conjuntocorreo','conjuntocorreoconsejo', 'conjuntocorreocomite', 'conjuntocelular', 'conjuntotelefono', 'conjuntoestado')
            ->orderBy('bloque_count', 'DESC')
            ->get();

        return view('admin.conjunto.index')->with('conjuntos', $conjuntos);
    }

    public function edit(Conjunto $conjunto)
    {
        $this->authorize('administrador', $conjunto);

        //$conjunto = Conjunto::find($id);
        $barrios = Barrio::all()->pluck('barrionombre', 'id');
        return view('admin.conjunto.edit')->with('conjunto',$conjunto)->with('barrios',$barrios);
    }

   public function update(Request $request, Conjunto $conjunto)
    {
        $this->authorize('administrador', $conjunto);

        //$conjunto = Conjunto::find($id);
        $request->validate([
            'conjuntonit'=>'required',
            'conjuntocorreo'=>'required|email',
            'conjuntocelular'=>'required|min:10'
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
        $conjunto->conjuntocorreo = $request->get('conjuntocorreo');
        $conjunto->conjuntocorreoconsejo = $request->get('conjuntocorreoconsejo');
        $conjunto->conjuntocorreocomite = $request->get('conjuntocorreocomite');
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
