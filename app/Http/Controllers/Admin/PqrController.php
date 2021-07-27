<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Asunto;
use App\Models\Conjunto;
use App\Models\DetallePqr;
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
        $this->middleware('can:admin.pqrs.edit')->only('edit', 'update');
        $this->middleware('can:admin.pqrs.destroy')->only('destroy');
    }

    public function index()
    {

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
            //return $pqr_abierta;

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
            'mensaje'=>'required|min:10'
         ]);

         if ($request->hasfile('archivo')){
            $this->validate($request, [
                'archivo' => 'required|mimes:pdf,jpeg,png,jpg,svg|max:2048',
            ]);

            $destinationPath = public_path('/storage');
            $file = $request->file('archivo');

            $folder = $destinationPath.'/'.$request->get('conjuntoid').'/'.'pqrs';
            if (!file_exists($folder)) {
                mkdir($folder, 0777,true);
            }

            $filename = $request->get('conjuntoid').'/'.'pqrs/'.date('YmdHis').'.'.$file->getClientOriginalExtension();
            //\Storage::disk('public')->put($filename,  \File::get($file));
            Image::make($file->getRealPath())->resize(250, 120, function ($constraint) {
            $constraint->aspectRatio();})->save($destinationPath.'/'.$filename);
         }

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
        return view('admin.pqr.index', compact('pqrs','pqr_abierta','pqr_proceso','pqr_resuelta','pqr_cerrada'));
    }

    public function edit($id)
    {
        $pqr = Pqr::join('asuntos', 'asuntos.id', 'pqrs.asuntoid')
            ->join('estado_pqrs', 'estado_pqrs.id', 'pqrs.estadoid')
            ->join('tipo_pqrs', 'tipo_pqrs.id', 'pqrs.tipopqrid')
            ->where('pqrs.id', $id)
            ->first();

        $flujos = DetallePqr::join('estado_pqrs', 'estado_pqrs.id', 'detalle_pqrs.estadoid')
            ->join('users', 'users.id', 'detalle_pqrs.userid')
            ->select('detalle_pqrs.*', 'estado_pqrs.estadonombre', 'users.name')
            ->where('detalle_pqrs.pqrid', $id)
            ->get();

        return view('admin.pqr.edit', compact('pqr', 'flujos'));
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
            'estadoid' => 4,
            'userid' => Auth::user()->id,
            'motivoid' => $request->get('motivo'),
        ]);

        return redirect()->route('admin.pqrs.index')->with('info','El Ticket fue '.$estado_text.' exitosamente');
    }

}
