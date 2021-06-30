<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pais;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

class PaisController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('can:admin.pais.index')->only('index');
        $this->middleware('can:admin.pais.create')->only('create', 'store');
        $this->middleware('can:admin.pais.edit')->only('edit', 'update');
        $this->middleware('can:admin.pais.destroy')->only('destroy');
    }

    public function index()
    {
        $paises = Pais::leftjoin("ciudads","ciudads.paisid", "=", "pais.id")
             ->select(Pais::raw('count(ciudads.id) as city_count, pais.id, paisnombre, paiscodigo, paisabreviatura, paisbandera'))
             ->groupBy('pais.id', 'paisnombre', 'paiscodigo', 'paisabreviatura', 'paisbandera')
             ->orderBy('city_count', 'DESC')
             ->get();

        return view('admin.pais.index')->with('paises', $paises);

    }

    public function create()
    {
        return view('admin.pais.create');
    }

    public function store(Request $request)
    {
        if ($request->hasfile('paisbandera')){
            $this->validate($request, [
                'paisbandera' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $destinationPath = public_path('/storage');
            $file = $request->file('paisbandera');
            $filename = 'banderas/'.date('YmdHis').'.'.$file->getClientOriginalExtension();
            Image::make($file->getRealPath())->resize(40, 20, function ($constraint) {
            $constraint->aspectRatio();})->save($destinationPath.'/'.$filename);
         }else{
             $filename = 'images/bandera.png';
         }
         $request->validate([
            'paisnombre'=>'required|min:3',
            'paisabreviatura'=>'required|min:2'
         ]);
         Pais::create([
            'paisnombre' => $request->get('paisnombre'),
            'paiscodigo' => $request->get('paiscodigo'),
            'paisabreviatura' => $request->get('paisabreviatura'),
            'paisbandera' => $filename,
         ]);

        return redirect()->route('admin.pais.index')->with('info','el pais fue agregado de forma exitosa');
    }

    public function show()
    {

        // $paises = Pais::leftjoin("ciudads","ciudads.paisid", "=", "pais.id")
        //      ->select(Pais::raw('count(ciudads.id) as city_count, pais.id, paisnombre, paiscodigo, paisabreviatura, paisbandera'))
        //      ->groupBy('pais.id', 'paisnombre', 'paiscodigo', 'paisabreviatura', 'paisbandera')
        //      ->orderBy('city_count', 'DESC')
        //      ->get();


        // return view('admin.pais.index')->with('paises', $paises);
    }

    public function edit($id)
    {
        $pais = Pais::find($id);
        return view('admin.pais.edit')->with('pais',$pais);
    }

    public function update(Request $request, $id)
    {
        $pais = Pais::find($id);
        $request->validate([
            'paisnombre'=>'required|min:3',
            'paisabreviatura'=>'required|min:2'
         ]);

        if ($request->hasfile('paisbandera')){
            $this->validate($request, [
                'paisbandera' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $destinationPath = public_path('/storage');
            $file = $request->file('paisbandera');
            $filename = 'banderas/'.date('YmdHis').'.'.$file->getClientOriginalExtension();
            $fullpath_old = $destinationPath.'/'.$pais->paisbandera;
            //\Storage::disk('public')->put($filename,  \File::get($file));
            Image::make($file->getRealPath())->resize(40, 20, function ($constraint) {
            $constraint->aspectRatio();})->save($destinationPath.'/'.$filename);
            if((File::exists($fullpath_old)) && ($pais->paisbandera <> 'images/bandera.png')) {
                File::delete($fullpath_old);
            }
            $pais->paisbandera = $filename;
        }

        $pais->paisnombre = $request->get('paisnombre');
        $pais->paiscodigo = $request->get('paiscodigo');
        $pais->paisabreviatura = $request->get('paisabreviatura');

        $pais->save();

         return redirect()->route('admin.pais.index')->with('info','El pais fue actualizado de forma exitosa');
    }

    public function destroy($id)
    {
        $pais = Pais::find($id);
        $destinationPath = public_path('/storage');
        $fullpath_old = $destinationPath.'/'.$pais->paisbandera;
        if((File::exists($fullpath_old)) && ($pais->paisbandera <> 'images/bandera.png')) {
            File::delete($fullpath_old);
        }
        $pais->delete();
        return redirect()->route('admin.pais.index')->with('info','El pais fue eliminado exitosamente');

        /*$pais->trashed(); Este sería el método papelera, y así podrás acceder al registro borrado.
        $pais = Pais::withTrashed()->get(); Así incluimos en una consulta a los registros que están en la papelera.
        $pais = Pais::onlyTrashed()->get(); Así consultarías solo los registros borrados de forma lógica.
        $pais->restore();Así, como puedes imaginar, restauras un registro, en otras palabras vuelves a null la columna deleted_at.
        $pais->forceDelete(); Oh. Esto es borrado físico, aquí dices adiós definitivamente al registro.*/
    }
}
