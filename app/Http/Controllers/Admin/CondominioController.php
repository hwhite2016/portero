<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Conjunto;
use App\Models\Barrio;
use App\Http\Requests\ValidarFormularioRequest;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class CondominioController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('can:admin.condominios.index')->only('index');
        $this->middleware('can:admin.condominios.create')->only('create', 'store');
        $this->middleware('can:admin.condominios.edit')->only('edit', 'update');
        $this->middleware('can:admin.condominios.destroy')->only('destroy');
    }

    public function index()
    {

        $conjuntos = Conjunto::leftjoin("bloques","bloques.conjuntoid", "=", "conjuntos.id")
             ->join("barrios","barrios.id", "=", "conjuntos.barrioid")
             ->join("ciudads","ciudads.id", "=", "barrios.ciudadid")
             ->select(conjunto::raw('count(bloques.id) as bloque_count, conjuntos.id, conjuntos.barrioid, ciudadnombre, barrionombre, conjuntonombre, conjuntologo, conjuntodireccion, conjuntocorreo, conjuntocelular, conjuntotelefono, conjuntoestado'))
             ->groupBy('conjuntos.id', 'conjuntos.barrioid', 'ciudadnombre', 'barrios.barrionombre', 'conjuntonombre', 'conjuntologo', 'conjuntodireccion','conjuntocorreo', 'conjuntocelular', 'conjuntotelefono', 'conjuntoestado')
             ->orderBy('bloque_count', 'DESC')
             ->get();
             return view('admin.condominio.index')->with('conjuntos', $conjuntos);

    }

    public function create()
    {
        $barrios = Barrio::all()->pluck('barrionombre', 'id');
        return view('admin.condominio.create')->with('barrios', $barrios);
    }

    public function store(ValidarFormularioRequest $request)
    {

         if ($request->hasfile('conjuntologo')){
            $this->validate($request, [
                'conjuntologo' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',
            ]);
            $destinationPath = public_path('/storage');
            $file = $request->file('conjuntologo');
            $filename = 'logos/'.date('YmdHis').'.'.$file->getClientOriginalExtension();
            //\Storage::disk('public')->put($filename,  \File::get($file));
            Image::make($file->getRealPath())->resize(250, 120, function ($constraint) {
            $constraint->aspectRatio();})->save($destinationPath.'/'.$filename);
         }else{
            $filename = 'images/yourlogo.png';
        }

        $conjuntos = Conjunto::create([
            'barrioid' => $request->get('barrioid'),
            'conjuntonombre' => $request->get('conjuntonombre'),
            'conjuntodireccion' => $request->get('conjuntodireccion'),
            'conjuntocorreo' => $request->get('conjuntocorreo'),
            'conjuntocelular' => $request->get('conjuntocelular'),
            'conjuntotelefono' => $request->get('conjuntotelefono'),
            'conjuntoestado' => $request->get('conjuntoestado'),
            'conjuntologo' => $filename
        ]);

        //$dep = $conjuntos->id;
        //$request->session()->push('dependencias', $dep);

        return redirect()->route('admin.condominios.show', $conjuntos->barrioid)->with('info','El conjunto fue agregado de forma exitosa');
    }

    public function show($id)
    {

        $conjuntos = Conjunto::leftjoin("bloques","bloques.conjuntoid", "=", "conjuntos.id")
            ->join("barrios","barrios.id", "=", "conjuntos.barrioid")
            ->join("ciudads","ciudads.id", "=", "barrios.ciudadid")
            ->select(conjunto::raw('count(bloques.id) as bloque_count, conjuntos.id, conjuntos.barrioid, ciudadnombre, barrionombre, conjuntonombre, conjuntologo, conjuntodireccion, conjuntocorreo, conjuntocelular, conjuntotelefono, conjuntoestado'))
            ->where('conjuntos.barrioid', '=', $id)
            ->groupBy('conjuntos.id', 'conjuntos.barrioid', 'ciudadnombre', 'barrios.barrionombre', 'conjuntonombre', 'conjuntologo', 'conjuntodireccion','conjuntocorreo', 'conjuntocelular', 'conjuntotelefono', 'conjuntoestado')
            ->orderBy('bloque_count', 'DESC')
            ->get();

        return view('admin.condominio.index')->with('conjuntos', $conjuntos);
    }

    public function edit($id)
    {
        $conjunto = Conjunto::find($id);
        $barrios = Barrio::all()->pluck('barrionombre', 'id');
        return view('admin.condominio.edit')->with('conjunto',$conjunto)->with('barrios',$barrios);
    }

   public function update(ValidarFormularioRequest $request, $id)
    {
        $conjunto = Conjunto::find($id);

         if ($request->hasfile('conjuntologo')){
            $this->validate($request, [
                'conjuntologo' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',
            ]);
            $destinationPath = public_path('/storage');
            $file = $request->file('conjuntologo');
            $filename = 'logos/'.date('YmdHis').'.'.$file->getClientOriginalExtension();
            $fullpath_old = $destinationPath.'/'.$conjunto->conjuntologo;
            //\Storage::disk('public')->put($filename,  \File::get($file));
            Image::make($file->getRealPath())->resize(250, 120, function ($constraint) {
            $constraint->aspectRatio();})->save($destinationPath.'/'.$filename);
            if((File::exists($fullpath_old)) && ($conjunto->conjuntologo <> 'images/yourlogo.png')) {
                File::delete($fullpath_old);
            }
            $conjunto->conjuntologo = $filename;
         }

         $conjunto->barrioid = $request->get('barrioid');
         $conjunto->conjuntonombre = $request->get('conjuntonombre');
         $conjunto->conjuntodireccion = $request->get('conjuntodireccion');
         $conjunto->conjuntocorreo = $request->get('conjuntocorreo');
         $conjunto->conjuntocelular = $request->get('conjuntocelular');
         $conjunto->conjuntotelefono = $request->get('conjuntotelefono');
         $conjunto->conjuntoestado = $request->get('conjuntoestado');

         $conjunto->save();

         return redirect()->route('admin.condominios.show', $request->get('barrioid'))->with('info','El conjunto fue actualizado de forma exitosa');

    }

    public function destroy($id)
    {

        $conjunto = Conjunto::find($id);
        $conjunto->delete();
        $destinationPath = public_path('/storage');
        $fullpath_old = $destinationPath.'/'.$conjunto->conjuntologo;
        if((File::exists($fullpath_old)) && ($conjunto->conjuntologo <> 'images/yourlogo.png')) {
            File::delete($fullpath_old);
        }
        return redirect()->route('admin.condominios.show', $conjunto->barrioid)->with('info','El conjunto fue eliminado exitosamente');

    }
}
