<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Adjunto;
use App\Models\Asunto;
use App\Models\Comentario;
use App\Models\Conjunto;
use App\Models\DetallePqr;
use App\Models\EstadoPqr;
use App\Models\Motivo;
use App\Models\Pqr;
use App\Models\TipoPqr;
use App\Models\User;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PqrController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('can:admin.pqrs.index')->only('index');
        $this->middleware('can:admin.pqrs.create')->only('create', 'store');
        $this->middleware('can:admin.pqrs.edit')->only('edit', 'update', 'changeEstado');
        $this->middleware('can:admin.pqrs.destroy')->only('destroy');
    }

    public function index()
    {
        $user = User::find(Auth::user()->id);
        if ($user->hasRole('_administrador')){
            $pqrs = Pqr::join('tipo_pqrs', 'tipo_pqrs.id', 'pqrs.tipopqrid')
                ->join('asuntos', 'asuntos.id', 'pqrs.asuntoid')
                ->join('estado_pqrs', 'estado_pqrs.id', 'pqrs.estadoid')
                ->select('pqrs.id', 'tipopqrnombre', 'asunto', 'mensaje', 'radicado', 'estadoid', 'estadonombre', 'pqrs.created_at')
                ->whereEstadoid(1)
                ->whereIn('conjuntoid', session('dependencias'))
                ->orderBy('radicado', 'DESC')
                ->get();

            $pqr_abierta = Pqr::whereIn('conjuntoid', session('dependencias'))
                ->whereEstadoid(1)
                ->whereIn('conjuntoid', session('dependencias'))
                ->count();
            $pqr_proceso = Pqr::whereIn('conjuntoid', session('dependencias'))
                ->whereEstadoid(2)
                ->whereIn('conjuntoid', session('dependencias'))
                ->count();
            $pqr_resuelta = Pqr::whereIn('conjuntoid', session('dependencias'))
                ->whereEstadoid(3)
                ->whereIn('conjuntoid', session('dependencias'))
                ->count();
            $pqr_cerrada = Pqr::whereIn('conjuntoid', session('dependencias'))
                ->whereEstadoid(4)
                ->whereIn('conjuntoid', session('dependencias'))
                ->count();
        }else{

            $pqrs = Pqr::join('tipo_pqrs', 'tipo_pqrs.id', 'pqrs.tipopqrid')
                ->join('asuntos', 'asuntos.id', 'pqrs.asuntoid')
                ->join('estado_pqrs', 'estado_pqrs.id', 'pqrs.estadoid')
                ->select('pqrs.id', 'tipopqrnombre', 'asunto', 'mensaje', 'radicado', 'estadoid', 'estadonombre', 'pqrs.created_at')
                ->whereUserid(Auth::user()->id)
                ->whereEstadoid(1)
                ->whereIn('conjuntoid', session('dependencias'))
                ->orderBy('radicado', 'DESC')
                ->get();

            $pqr_abierta = Pqr::whereIn('conjuntoid', session('dependencias'))
                ->whereUserid(Auth::user()->id)
                ->whereEstadoid(1)
                ->whereIn('conjuntoid', session('dependencias'))
                ->count();
            $pqr_proceso = Pqr::whereIn('conjuntoid', session('dependencias'))
                ->whereUserid(Auth::user()->id)
                ->whereEstadoid(2)
                ->whereIn('conjuntoid', session('dependencias'))
                ->count();
            $pqr_resuelta = Pqr::whereIn('conjuntoid', session('dependencias'))
                ->whereUserid(Auth::user()->id)
                ->whereEstadoid(3)
                ->whereIn('conjuntoid', session('dependencias'))
                ->count();
            $pqr_cerrada = Pqr::whereIn('conjuntoid', session('dependencias'))
                ->whereUserid(Auth::user()->id)
                ->whereEstadoid(4)
                ->whereIn('conjuntoid', session('dependencias'))
                ->count();
        }

        return view('admin.pqr.index', compact('pqrs','pqr_abierta','pqr_proceso','pqr_resuelta','pqr_cerrada'));
    }

    public function getMotivo(){

        $motivo = Motivo::all();
        return response()->json(['motivo' => $motivo], 200);

    }

    public function create()
    {
        $tipo_pqrs = TipoPqr::all()->pluck('tipopqrnombre', 'id');
        $conjuntos = Conjunto::whereIn('conjuntos.id', session('dependencias'))->pluck('conjuntonombre', 'id');
        $asuntos = Asunto::all()->pluck('asunto', 'id');

        return view('admin.pqr.create', compact('tipo_pqrs', 'conjuntos', 'asuntos'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'conjuntoid'=>'required',
            'tipopqrid'=>'required',
            'asuntoid'=>'required',
            'mensaje'=>'required|min:10|max:3000'
        ]);

        $radicado = Pqr::whereConjuntoid($request->get('conjuntoid'))->max('id') + 1;

        $pqrs = Pqr::create([
            'conjuntoid' => $request->get('conjuntoid'),
            'tipopqrid' => $request->get('tipopqrid'),
            'userid' => Auth::user()->id,
            'asuntoid' => $request->get('asuntoid'),
            'mensaje' => $request->get('mensaje'),
            'radicado' => $radicado,
            'estadoid' => 1,
        ]);

        if ($request->hasfile('archivo')){
            $this->validate($request, [
                'archivo' => 'required|mimes:pdf,jpeg,png,jpg,svg|max:2048',
            ]);

            $destinationPath = public_path('storage/'.$request->get('conjuntoid').'/'.'pqrs');
            $file = $request->file('archivo');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777,true);
            }

            $filename = date('YmdHis').'.'.$file->getClientOriginalExtension();
            //\Storage::disk('public')->put($filename,  \File::get($file));
            if($file->getClientOriginalExtension() == 'pdf'){
                $ruta = $destinationPath.'/'.$filename;
                copy($file, $ruta);
            }else{
                Image::make($file->getRealPath())->resize(800, 600, function ($constraint) {
                $constraint->aspectRatio();})->save($destinationPath.'/'.$filename);
            }

            Adjunto::create([
                'pqrid' => $pqrs->id,
                'archivo' => $filename,
                'userid' => Auth::user()->id,
            ]);
        }

         DetallePqr::create([
            'pqrid' => $pqrs->id,
            'estadoid' => 1,
            'userid' => Auth::user()->id,
        ]);

        // $admin = User::join('model_has_roles', 'users.id', 'model_has_roles.model_id')
        //     ->join('roles', 'roles.id', 'model_has_roles.role_id')
        //     ->join('persona_conjuntos', 'persona_conjuntos.persona_id', 'users.personaid')
        //     ->join('empleados', 'empleados.personaid', 'persona_conjuntos.persona_id')
        //     ->select('users.id')
        //     ->where('roles.name', '_administrador')
        //     ->where('persona_conjuntos.conjunto_id', $request->get('conjuntoid'))
        //     ->first();

        // DetallePqr::create([
        //     'pqrid' => $pqrs->id,
        //     'estadoid' => 5,
        //     'userid' => $admin->id,
        // ]);

        return redirect()->route('admin.pqrs.index')->with('info','El Ticket fue creado de forma exitosa');

    }

    public function show($id)
    {
        $user = User::find(Auth::user()->id);
        if ($user->hasRole('_administrador')){

            $pqrs = Pqr::join('tipo_pqrs', 'tipo_pqrs.id', 'pqrs.tipopqrid')
                ->join('asuntos', 'asuntos.id', 'pqrs.asuntoid')
                ->join('estado_pqrs', 'estado_pqrs.id', 'pqrs.estadoid')
                ->select('pqrs.id', 'tipopqrnombre', 'asunto', 'mensaje', 'radicado', 'estadoid', 'estadonombre', 'pqrs.created_at')
                ->whereEstadoid($id)
                ->whereIn('conjuntoid', session('dependencias'))
                ->orderBy('radicado', 'DESC')
                ->get();

            $pqr_abierta = Pqr::whereIn('conjuntoid', session('dependencias'))
                ->whereEstadoid(1)
                ->whereIn('conjuntoid', session('dependencias'))
                ->count();
            $pqr_proceso = Pqr::whereIn('conjuntoid', session('dependencias'))
                ->whereEstadoid(2)
                ->whereIn('conjuntoid', session('dependencias'))
                ->count();
            $pqr_resuelta = Pqr::whereIn('conjuntoid', session('dependencias'))
                ->whereEstadoid(3)
                ->whereIn('conjuntoid', session('dependencias'))
                ->count();
            $pqr_cerrada = Pqr::whereIn('conjuntoid', session('dependencias'))
                ->whereEstadoid(4)
                ->whereIn('conjuntoid', session('dependencias'))
                ->count();
        }else{

            $pqrs = Pqr::join('tipo_pqrs', 'tipo_pqrs.id', 'pqrs.tipopqrid')
                ->join('asuntos', 'asuntos.id', 'pqrs.asuntoid')
                ->join('estado_pqrs', 'estado_pqrs.id', 'pqrs.estadoid')
                ->select('pqrs.id', 'tipopqrnombre', 'asunto', 'mensaje', 'radicado', 'estadoid', 'estadonombre', 'pqrs.created_at')
                ->whereUserid(Auth::user()->id)
                ->whereEstadoid($id)
                ->whereIn('conjuntoid', session('dependencias'))
                ->orderBy('radicado', 'DESC')
                ->get();

            $pqr_abierta = Pqr::whereIn('conjuntoid', session('dependencias'))
                ->whereUserid(Auth::user()->id)
                ->whereEstadoid(1)
                ->whereIn('conjuntoid', session('dependencias'))
                ->count();
            $pqr_proceso = Pqr::whereIn('conjuntoid', session('dependencias'))
                ->whereUserid(Auth::user()->id)
                ->whereEstadoid(2)
                ->whereIn('conjuntoid', session('dependencias'))
                ->count();
            $pqr_resuelta = Pqr::whereIn('conjuntoid', session('dependencias'))
                ->whereUserid(Auth::user()->id)
                ->whereEstadoid(3)
                ->whereIn('conjuntoid', session('dependencias'))
                ->count();
            $pqr_cerrada = Pqr::whereIn('conjuntoid', session('dependencias'))
                ->whereUserid(Auth::user()->id)
                ->whereEstadoid(4)
                ->whereIn('conjuntoid', session('dependencias'))
                ->count();
        }

        return view('admin.pqr.index', compact('pqrs','pqr_abierta','pqr_proceso','pqr_resuelta','pqr_cerrada'));
    }

    public function edit($id)
    {
        $pqr = Pqr::join('asuntos', 'asuntos.id', 'pqrs.asuntoid')
            ->join('estado_pqrs', 'estado_pqrs.id', 'pqrs.estadoid')
            ->join('tipo_pqrs', 'tipo_pqrs.id', 'pqrs.tipopqrid')
            ->join('users', 'users.id', 'pqrs.userid')
            ->join('residentes', 'residentes.personaid', 'users.personaid')
            ->join('unidads', 'unidads.id', 'residentes.unidadid')
            ->join('bloques', 'bloques.id', 'unidads.bloqueid')
            ->select('pqrs.*', 'estadoid', 'estadonombre', 'asunto', 'tipopqrnombre', 'users.name', 'unidadnombre', 'bloquenombre')
            ->where('pqrs.id', $id)
            ->first();
dd($pqr);
        $flujos = DetallePqr::join('estado_pqrs', 'estado_pqrs.id', 'detalle_pqrs.estadoid')
            ->join('users', 'users.id', 'detalle_pqrs.userid')
            ->leftjoin('motivos', 'motivos.id', 'detalle_pqrs.motivoid')
            ->select('detalle_pqrs.*', 'estado_pqrs.estadonombre', 'users.name', 'motivo')
            ->where('detalle_pqrs.pqrid', $id)
            ->orderBy('detalle_pqrs.created_at')
            ->get();

        $adjuntos = Adjunto::join('users', 'users.id', 'adjuntos.userid')
            ->select('adjuntos.*', 'users.name')
            ->where('adjuntos.pqrid', $id)
            ->orderBy('adjuntos.created_at', 'DESC')
            ->get();

        $comentarios = Comentario::join('users', 'users.id', 'comentarios.userid')
            ->select('comentarios.*', 'users.name')
            ->where('comentarios.pqrid', $id)
            ->orderBy('comentarios.created_at', 'DESC')
            ->get();

        if($pqr->estadoid == 1){
            $estados = EstadoPqr::whereIn('id',[1,2,3])->pluck('estadonombre', 'id');
        }else{
            $estados = EstadoPqr::whereIn('id',[2,3])->pluck('estadonombre', 'id');
        }
        // $user = User::find(Auth::user()->id);
        // if ($user->hasRole('_administrador')){
        //     $estados = EstadoPqr::where('estadoid','<>','4')->pluck('estadonombre', 'id');
        // }else{
        //     $estados = EstadoPqr::orderBy('id')->pluck('estadonombre', 'id');
        // }

        return view('admin.pqr.edit', compact('pqr', 'flujos', 'adjuntos', 'comentarios', 'estados'));
    }

    public function update(Request $request, $id){
        $pqrs = Pqr::find($id);

        $request->validate([
            'comentario'=>'max:400'
        ]);

        if($request->get('estadoid')){
            $pqrs->update([
                'estadoid'=>$request->get('estadoid'),
            ]);

            DetallePqr::create([
                'pqrid' => $pqrs->id,
                'estadoid' => $request->get('estadoid'),
                'userid' => Auth::user()->id,
                //'motivoid' => $request->get('motivo'),
            ]);
        }

        if ($request->hasfile('archivo')){
            $this->validate($request, [
                'archivo' => 'required|mimes:pdf,jpeg,png,jpg,svg|max:2048',
            ]);

            $destinationPath = public_path('storage/'.$request->get('conjuntoid').'/'.'pqrs');
            $file = $request->file('archivo');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777,true);
            }

            $filename = date('YmdHis').'.'.$file->getClientOriginalExtension();
            //\Storage::disk('public')->put($filename,  \File::get($file));
            if($file->getClientOriginalExtension() == 'pdf'){
                $ruta = $destinationPath.'/'.$filename;
                copy($file, $ruta);
            }else{
                Image::make($file->getRealPath())->resize(800, 600, function ($constraint) {
                $constraint->aspectRatio();})->save($destinationPath.'/'.$filename);
            }

            Adjunto::create([
                'pqrid' => $pqrs->id,
                'archivo' => $filename,
                'userid' => Auth::user()->id,
            ]);
        }
        if($request->get('comentario')){
            Comentario::create([
                'pqrid' => $pqrs->id,
                'comentario' => $request->get('comentario'),
                'userid' => Auth::user()->id,
            ]);
        }
        return redirect()->route('admin.pqrs.edit', $pqrs->id)->with('info','El Ticket fue actualizado exitosamente');
    }

    public function changeEstado(Request $request, $id)
    {
        //return $request;
        $pqr = Pqr::find($id);
        $estado = 4; $estado_text = "cerrado";
        if($request->get('estadoid') == 4) {
            $estado = 1;
            $estado_text = "abierto";
        }
        $pqr->update([
            'estadoid'=> $estado,
        ]);

        DetallePqr::create([
            'pqrid' => $pqr->id,
            'estadoid' => $estado,
            'userid' => Auth::user()->id,
            'motivoid' => $request->get('motivo'),
        ]);

        return redirect()->route('admin.pqrs.index')->with('info','El Ticket fue '.$estado_text.' exitosamente');
    }

    public function destroy(Request $request, $id)
    {
        //return $request;
        $pqr = Pqr::find($id);
        $estado = 4; $estado_text = "cerrado";
        if($request->get('estadoid') == 4) {
            $estado = 1;
            $estado_text = "abierto";
        }
        $pqr->update([
            'estadoid'=> $estado,
        ]);

        DetallePqr::create([
            'pqrid' => $pqr->id,
            'estadoid' => $estado,
            'userid' => Auth::user()->id,
            'motivoid' => $request->get('motivo'),
        ]);

        return redirect()->route('admin.pqrs.index')->with('info','El Ticket fue '.$estado_text.' exitosamente');
    }

}
