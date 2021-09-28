<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Conjunto;
use App\Models\Norma;
use App\Models\TipoNorma;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class NormaController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('can:admin.normas.index')->only('index');
        $this->middleware('can:admin.normas.create')->only('create', 'store');
        $this->middleware('can:admin.normas.edit')->only('edit', 'update');
        $this->middleware('can:admin.normas.destroy')->only('destroy');
    }

    public function index()
    {

        $normas = Norma::join("tipo_normas","tipo_normas.id", "=", "normas.tiponorma_id")
             ->join('conjuntos','conjuntos.id','=','normas.conjuntoid')
             ->select('normas.*', 'tipo_normas.tiponormanombre', 'conjuntonombre')
             ->whereIn('conjuntos.id', session('dependencias'))
             ->orderBy('tiponorma_id', 'ASC')
             ->get();

        return view('admin.norma.index', compact('normas'));
    }

    public function create(Request $request)
    {
        $tipo_normas = TipoNorma::orderBy('tiponormanombre', 'ASC')->pluck('tiponormanombre', 'id');
        $conjuntos = Conjunto::whereIn('conjuntos.id', session('dependencias'))->pluck('conjuntonombre', 'id');

        return view('admin.norma.create', compact('tipo_normas', 'conjuntos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'conjuntoid'=>'required',
            'normanombre'=>'required|max:200',
            'ruta'=>'max:200',
            'tiponorma_id' => 'required'
        ]);

        if ($request->hasfile('adjunto')){
            $this->validate($request, [
                'adjunto' => 'required|mimes:pdf,jpeg,png,jpg,svg|max:2048',
            ]);

            $destinationPath = public_path('storage/'.$request->get('conjuntoid').'/'.'documentos');
            $file = $request->file('adjunto');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777,true);
            }

            $filename = date('YmdHis').'.'.$file->getClientOriginalExtension();
            if($file->getClientOriginalExtension() == 'pdf'){
                $ruta = $destinationPath.'/'.$filename;
                copy($file, $ruta);
            }else{
                Image::make($file->getRealPath())->resize(800, 600, function ($constraint) {
                $constraint->aspectRatio();})->save($destinationPath.'/'.$filename);
            }
            Norma::create([
                'conjuntoid'=>$request->get('conjuntoid'),
                'tiponorma_id'=>$request->get('tiponorma_id'),
                'normanombre'=>$request->get('normanombre'),
                'ruta'=>$request->get('ruta'),
                'adjunto' => $filename
            ]);
        }else{
            Norma::create([
                'conjuntoid'=>$request->get('conjuntoid'),
                'tiponorma_id'=>$request->get('tiponorma_id'),
                'normanombre'=>$request->get('normanombre'),
                'ruta'=>$request->get('ruta')
            ]);
        }

        return redirect()->route('admin.normas.index')->with('info','El documento fue agregado de forma exitosa');

    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $norma = Norma::find($id);
        $tipo_normas = TipoNorma::orderBy('tiponormanombre', 'ASC')->pluck('tiponormanombre', 'id');
        $conjuntos = Conjunto::whereIn('conjuntos.id', session('dependencias'))->pluck('conjuntonombre', 'id');


        return view('admin.norma.edit', compact('norma', 'tipo_normas', 'conjuntos'));

    }

    public function update(Request $request, $id)
    {
        $norma = Norma::find($id);
        $request->validate([
            'conjuntoid'=>'required',
            'normanombre'=>'required|max:200',
            'ruta'=>'max:200',
            'tiponorma_id'=>'required'
        ]);

        if ($request->hasfile('adjunto')){
            $this->validate($request, [
                'adjunto' => 'required|mimes:pdf,jpeg,png,jpg,svg|max:2048',
            ]);

            $destinationPath = public_path('storage/'.$request->get('conjuntoid').'/'.'documentos');
            $file = $request->file('adjunto');
            $filename = date('YmdHis').'.'.$file->getClientOriginalExtension();
            $fullpath_old = $destinationPath.'/'.$norma->adjunto;
            if($file->getClientOriginalExtension() == 'pdf'){
                $ruta = $destinationPath.'/'.$filename;
                copy($file, $ruta);
            }else{
                Image::make($file->getRealPath())->resize(800, 600, function ($constraint) {
                $constraint->aspectRatio();})->save($destinationPath.'/'.$filename);
            }

            if(File::exists($fullpath_old)) {
                File::delete($fullpath_old);
            }
            $norma->adjunto = $filename;
        }

        $norma->conjuntoid = $request->get('conjuntoid');
        $norma->tiponorma_id = $request->get('tiponorma_id');
        $norma->normanombre = $request->get('normanombre');
        $norma->ruta = $request->get('ruta');

        $norma->save();

        return redirect()->route('admin.normas.index')->with('info','El documento fue actualizado de forma exitosa');

    }

    public function destroy(Request $request, $id)
    {
        $norma = Norma::find($id);
        $norma->delete();

        $destinationPath = public_path('/storage');
        $fullpath_old = $destinationPath.'/'.$norma->adjunto;
        if(File::exists($fullpath_old))  {
            File::delete($fullpath_old);
        }

        return redirect()->route('admin.normas.index')->with('info','El documento fue eliminado exitosamente');

    }
}
