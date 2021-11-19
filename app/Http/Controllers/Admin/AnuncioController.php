<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\ComunicadoMailable;
use App\Models\Anuncio;
use App\Models\Bloque;
use App\Models\Conjunto;
use App\Models\TipoAnuncio;
use App\Models\Unidad;
use App\Models\User;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;

class AnuncioController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('can:admin.anuncios.index')->only('index');
        $this->middleware('can:admin.anuncios.create')->only('create', 'store');
        $this->middleware('can:admin.anuncios.edit')->only('edit', 'update');
        $this->middleware('can:admin.anuncios.destroy')->only('destroy');
    }

    public function index(Request $request)
    {
       return view('admin.anuncio.index');
    }

    public function create()
    {
        $conjuntos = Conjunto::whereIn('id', session('dependencias'))->pluck('conjuntonombre', 'id');
        $bloques = Bloque::whereIn('conjuntoid', session('dependencias'))->pluck('bloquenombre', 'id');
        $bloques->prepend('Todos', '0');
        $tipo_anuncio = TipoAnuncio::all()->pluck('tipoanuncionombre', 'id');
        return view('admin.anuncio.create', compact('conjuntos','bloques','tipo_anuncio'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'conjuntoid'=>'required',
            'tipoanuncioid'=>'required',
            'anuncionombre'=>'required|min:3|max:150'
        ]);

        $ruta = null;
        if ($request->hasfile('anuncioadjunto')){
            $this->validate($request, [
                'anuncioadjunto' => 'required|mimes:pdf,jpeg,png,jpg,svg|max:2048',
            ]);

            $destinationPath = public_path('storage/'.$request->get('conjuntoid').'/'.'comunicados');
            $file = $request->file('anuncioadjunto');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777,true);
            }
            //$filename_db = $request->get('conjuntoid').'/'.'comunicados/'.date('YmdHis').'.'.$file->getClientOriginalExtension();

            $filename = date('YmdHis').'.'.$file->getClientOriginalExtension();
            //\Storage::disk('public')->put($filename,  \File::get($file));
            if(strtolower($file->getClientOriginalExtension()) == 'pdf'){
                $ruta = $destinationPath.'/'.$filename;
                copy($file, $ruta);
            }else{
                Image::make($file->getRealPath())->resize(800, 600, function ($constraint) {
                $constraint->aspectRatio();})->save($destinationPath.'/'.$filename);
            }

        }else{
            $filename = null;
        }

        if($request->get('bloqueid') != null && $request->get('bloqueid') > 0){
            $bloqueid = $request->get('bloqueid');

            if($request->get('unidadid')){
                $unidadid = implode(",", $request->get('unidadid'));
            }else{
                $unidadid = null;
            }
        }else{
            $bloqueid = null;
            $unidadid = null;
        }

        $anuncio = Anuncio::create([
            'conjuntoid' => $request->get('conjuntoid'),
            'tipoanuncioid' => $request->get('tipoanuncioid'),
            'bloqueid' => $bloqueid,
            'unidadid' => $unidadid,
            'anuncionombre' => $request->get('anuncionombre'),
            'anunciodescripcion' => $request->get('anunciodescripcion'),
            'anuncioadjunto' => $filename,
        ]);

        return redirect()->route('admin.anuncios.index')->with('info','El comunicado fue guardado de forma exitosa');
    }

    public function delFile($id)
    {
        $anuncio = Anuncio::find($id);

        $destinationPath = public_path('storage/'.$anuncio->conjuntoid.'/'.'comunicados');
        $fullpath_old = $destinationPath.'/'.$anuncio->anuncioadjunto;
        if(File::exists($fullpath_old)) {
            File::delete($fullpath_old);
        }
        $anuncio->update([
            'anuncioadjunto'=> null
        ]);
        return redirect()->route('admin.anuncios.edit', $id);
    }

    public function enviar($id)
    {

        $ruta = null;
        $anuncio = Anuncio::join('tipo_anuncios', 'tipo_anuncios.id', 'anuncios.tipoanuncioid')
            ->join('conjuntos', 'conjuntos.id', 'anuncios.conjuntoid')
            ->join('empleados', 'empleados.conjuntoid', 'conjuntos.id')
            ->join('personas', 'personas.id', 'empleados.personaid')
            ->select('conjuntonombre', 'personanombre', 'anuncionombre', 'tipoanuncionombre', 'anunciodescripcion', 'anuncios.conjuntoid', 'anuncioadjunto','bloqueid','unidadid')
            ->where('empleados.cargo_id', 10)
            ->where('anuncios.id', $id)->first();

        if($anuncio->bloqueid){
            if($anuncio->unidadid){
                $unidades = explode(",", $anuncio->unidadid);
                $users = User::join('residentes', 'residentes.personaid', 'users.personaid')
                ->join('unidads', 'unidads.id', 'residentes.unidadid')
                ->select('name','email','unidadnombre')
                ->whereIn('unidads.id', $unidades)
                ->get();
            }else{
                $users = User::join('residentes', 'residentes.personaid', 'users.personaid')
                ->join('unidads', 'unidads.id', 'residentes.unidadid')
                ->join('bloques', 'bloques.id', 'unidads.bloqueid')
                ->select('name','email','unidadnombre')
                ->where('bloques.id', $anuncio->bloqueid)
                ->get();
            }

        }else{
            $users = User::join('persona_conjuntos', 'users.personaid', 'persona_conjuntos.persona_id')
            ->join('residentes', 'residentes.personaid', 'users.personaid')
            ->join('unidads', 'unidads.id', 'residentes.unidadid')
            ->select('name','email')
            ->whereIn('conjunto_id', session('dependencias'))
            ->get();
        }

        $data = [
            'subject' => 'Nuevo Comunicado',
            'conjunto' => $anuncio->conjuntonombre,
            'administrador' => $anuncio->personanombre,
            'tipo' => $anuncio->tipoanuncionombre,
            'titulo' => $anuncio->anuncionombre,
            'mensaje' => $anuncio->anunciodescripcion,
            'ruta' => NULL
        ];

        if($anuncio->anuncioadjunto) {
            $destinationPath = public_path('storage/'.$anuncio->conjuntoid.'/'.'comunicados');
            $ruta = $destinationPath.'/'.$anuncio->anuncioadjunto;
            $data['ruta'] = $ruta;
        }

        foreach($users as $user){
            $data['name'] = $user->name;
            Mail::to($user->email)->send(new ComunicadoMailable($data));
        }

        $comunicado = Anuncio::find($id);
        $comunicado->update([
            'anunciofechaentrega'=> now()
        ]);

        return redirect()->route('admin.anuncios.index')->with('info','El comunicado fue enviado de forma exitosa');

    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $anuncio = Anuncio::find($id);
        $unidads = explode(",", $anuncio->unidadid);
        $unidades = Unidad::whereIn('id', $unidads)->pluck('unidadnombre','id');

        $conjuntos = Conjunto::whereIn('id', session('dependencias'))->pluck('conjuntonombre', 'id');
        $bloques = Bloque::whereIn('conjuntoid', session('dependencias'))->pluck('bloquenombre', 'id');
        $bloques->prepend('Todos', '0');
        $tipo_anuncio = TipoAnuncio::all()->pluck('tipoanuncionombre', 'id');

        return view('admin.anuncio.edit', compact('anuncio', 'unidades','conjuntos','bloques','tipo_anuncio'));
    }

    public function update(Request $request, Anuncio $anuncio)
    {
        $request->validate([
            'conjuntoid'=>'required',
            'tipoanuncioid'=>'required',
            'anuncionombre'=>'required|min:3|max:150'
        ]);

        $ruta = null;
        if ($request->hasfile('anuncioadjunto')){
            $this->validate($request, [
                'anuncioadjunto' => 'required|mimes:pdf,jpeg,png,jpg,svg|max:2048',
            ]);

            $destinationPath = public_path('storage/'.$request->get('conjuntoid').'/'.'comunicados');
            $file = $request->file('anuncioadjunto');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777,true);
            }
            //$filename_db = $request->get('conjuntoid').'/'.'comunicados/'.date('YmdHis').'.'.$file->getClientOriginalExtension();
            $fullpath_old = $destinationPath.'/'.$anuncio->anuncioadjunto;
            $filename = date('YmdHis').'.'.$file->getClientOriginalExtension();
            //\Storage::disk('public')->put($filename,  \File::get($file));
            if(strtolower($file->getClientOriginalExtension()) == 'pdf'){
                $ruta = $destinationPath.'/'.$filename;
                copy($file, $ruta);
            }else{
                Image::make($file->getRealPath())->resize(800, 600, function ($constraint) {
                $constraint->aspectRatio();})->save($destinationPath.'/'.$filename);
            }

            if(File::exists($fullpath_old)) {
                File::delete($fullpath_old);
            }
            $anuncio->anuncioadjunto = $filename;

        }

        $anuncio->conjuntoid = $request->get('conjuntoid');
        $anuncio->tipoanuncioid = $request->get('tipoanuncioid');
        if($request->get('bloqueid') != null && $request->get('bloqueid') > 0){
            $anuncio->bloqueid = $request->get('bloqueid');

            if($request->get('unidadid')){
                $anuncio->unidadid = implode(",", $request->get('unidadid'));
            }else{
                $anuncio->unidadid = null;
            }
        }else{
            $anuncio->bloqueid = null;
            $anuncio->unidadid = null;
        }


        $anuncio->anuncionombre = $request->get('anuncionombre');
        $anuncio->anunciodescripcion = $request->get('anunciodescripcion');


        $anuncio->save();

        return redirect()->route('admin.anuncios.index')->with('info','El comunicado fue guardado de forma exitosa');

    }

    public function destroy($id)
    {
        $anuncio = Anuncio::find($id);
        $anuncio->delete();

        $destinationPath = public_path('storage/'.$anuncio->conjuntoid.'/'.'comunicados');
        $fullpath_old = $destinationPath.'/'.$anuncio->anuncioadjunto;
        if(File::exists($fullpath_old)) {
            File::delete($fullpath_old);
        }

        return redirect()->route('admin.anuncios.index')->with('info','El comunicado fue eliminado exitosamente');
    }
}
