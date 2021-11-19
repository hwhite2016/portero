<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\PqrMailable;
use App\Models\Adjunto;
use App\Models\Asunto;
use App\Models\Comentario;
use App\Models\Conjunto;
use App\Models\DetallePqr;
use App\Models\Empleado;
use App\Models\EstadoPqr;
use App\Models\Motivo;
use App\Models\Organo;
use App\Models\Pqr;
use App\Models\TipoPqr;
use App\Models\User;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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
        if ($user->hasRole('Residente')){
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
        }else{

            $pqrs = Pqr::join('tipo_pqrs', 'tipo_pqrs.id', 'pqrs.tipopqrid')
                ->join('empleados', 'empleados.organo_id', 'pqrs.organo_id')
                ->join('users', 'users.personaid', 'empleados.personaid')
                ->join('asuntos', 'asuntos.id', 'pqrs.asuntoid')
                ->join('estado_pqrs', 'estado_pqrs.id', 'pqrs.estadoid')
                ->select('pqrs.id', 'tipopqrnombre', 'asunto', 'mensaje', 'radicado', 'estadoid', 'estadonombre', 'pqrs.created_at')
                ->where('users.id', Auth::user()->id)
                ->whereEstadoid(1)
                ->whereIn('pqrs.conjuntoid', session('dependencias'))
                ->orderBy('radicado', 'DESC')
                ->get();

            $pqr_abierta = Pqr::whereIn('pqrs.conjuntoid', session('dependencias'))
                ->join('empleados', 'empleados.organo_id', 'pqrs.organo_id')
                ->join('users', 'users.personaid', 'empleados.personaid')
                ->where('users.id', Auth::user()->id)
                ->whereEstadoid(1)
                ->count();
            $pqr_proceso = Pqr::whereIn('pqrs.conjuntoid', session('dependencias'))
                ->join('empleados', 'empleados.organo_id', 'pqrs.organo_id')
                ->join('users', 'users.personaid', 'empleados.personaid')
                ->where('users.id', Auth::user()->id)
                ->whereEstadoid(2)
                ->count();
            $pqr_resuelta = Pqr::whereIn('pqrs.conjuntoid', session('dependencias'))
                ->join('empleados', 'empleados.organo_id', 'pqrs.organo_id')
                ->join('users', 'users.personaid', 'empleados.personaid')
                ->where('users.id', Auth::user()->id)
                ->whereEstadoid(3)
                ->count();
            $pqr_cerrada = Pqr::whereIn('pqrs.conjuntoid', session('dependencias'))
                ->join('empleados', 'empleados.organo_id', 'pqrs.organo_id')
                ->join('users', 'users.personaid', 'empleados.personaid')
                ->where('users.id', Auth::user()->id)
                ->whereEstadoid(4)
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
        $asuntos = Asunto::orderBy('asunto')->pluck('asunto', 'id');
        $organos = Organo::whereOrganopqr(1)->whereIn('conjuntoid', session('dependencias'))
            ->orderBy('organonombre')->pluck('organonombre', 'id');

        return view('admin.pqr.create', compact('tipo_pqrs', 'conjuntos', 'asuntos', 'organos'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'conjuntoid'=>'required',
            'tipopqrid'=>'required',
            'asuntoid'=>'required',
            'organo_id'=>'required',
            'mensaje'=>'required|min:10|max:3000'
        ]);

        $radicado = Pqr::whereConjuntoid($request->get('conjuntoid'))->max('id') + 1;

        $pqrs = Pqr::create([
            'conjuntoid' => $request->get('conjuntoid'),
            'tipopqrid' => $request->get('tipopqrid'),
            'userid' => Auth::user()->id,
            'asuntoid' => $request->get('asuntoid'),
            'organo_id' => $request->get('organo_id'),
            'mensaje' => $request->get('mensaje'),
            'radicado' => $radicado,
            'estadoid' => 1,
        ]);

        $pqrs->organos()->sync($request->organos);

        $ruta = null;
        if ($request->hasfile('adjunto')){
            $this->validate($request, [
                'adjunto' => 'required|mimes:pdf,jpeg,png,jpg,svg|max:2048',
            ]);

            $destinationPath = public_path('storage/'.$request->get('conjuntoid').'/'.'pqrs');
            $file = $request->file('adjunto');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777,true);
            }

            $filename = date('YmdHis').'.'.$file->getClientOriginalExtension();
            //\Storage::disk('public')->put($filename,  \File::get($file));
            if(strtolower($file->getClientOriginalExtension()) == 'pdf'){
                $ruta = $destinationPath.'/'.$filename;
                copy($file, $ruta);
            }else{
                Image::make($file->getRealPath())->resize(800, 600, function ($constraint) {
                $constraint->aspectRatio();})->save($destinationPath.'/'.$filename);
            }

            Adjunto::create([
                'pqrid' => $pqrs->id,
                'adjunto' => $filename,
                'userid' => Auth::user()->id,
            ]);
        }

         DetallePqr::create([
            'pqrid' => $pqrs->id,
            'estadoid' => 1,
            'userid' => Auth::user()->id,
        ]);


        $pqr_correo = Pqr::join('tipo_pqrs', 'tipo_pqrs.id', 'pqrs.tipopqrid')
            ->join('organos', 'organos.id', 'pqrs.organo_id')
            ->join('conjuntos', 'conjuntos.id', 'pqrs.conjuntoid')
            ->join('asuntos', 'asuntos.id', 'pqrs.asuntoid')
            ->join('users', 'users.id', 'pqrs.userid')
            ->join('personas', 'personas.id', 'users.personaid')
            ->join('tipo_documentos','tipo_documentos.id','personas.tipodocumentoid')
            ->join('residentes', 'residentes.personaid', 'personas.id')
            ->join('unidads', 'unidads.id', 'residentes.unidadid')
            ->join('bloques', 'bloques.id', 'unidads.bloqueid')
            ->select('pqrs.id', 'tipopqrnombre', 'tipopqrtiempo', 'asunto', 'organonombre', 'organocorreo', 'mensaje', 'radicado',
                    'pqrs.created_at', 'personadocumento', 'personanombre', 'personacorreo', 'personacelular', 'tipodocumentoabreviatura',
                    'bloquenombre', 'unidadnombre', 'conjuntonombre')
            ->where('pqrs.id', $pqrs->id)

            ->first();

        $fecha_plazo = $this->fecha_plazo($pqr_correo->created_at, $pqr_correo->tipopqrtiempo);
        $data = [
            'id' => $pqr_correo->id,
            'tipo' => $pqr_correo->tipopqrnombre,
            'subject' => '[Ticket #'.str_pad($pqr_correo->radicado,6,"0", STR_PAD_LEFT).'] - Ha sido registrado un nuevo ticket',
            'asunto' => $pqr_correo->asunto,
            'agente' => $pqr_correo->organonombre,
            'mensaje' => $pqr_correo->mensaje,
            'radicado' => 'TK-'.str_pad($pqr_correo->radicado,6,"0", STR_PAD_LEFT),
            'fecha_radicado' => $pqr_correo->created_at,
            'tiempo' => $pqr_correo->tipopqrtiempo,
            'plazo' => $fecha_plazo,
            'personanombre' => $pqr_correo->personanombre,
            'tipodocumentoabreviatura' => $pqr_correo->tipodocumentoabreviatura,
            'personadocumento' => $pqr_correo->personadocumento,
            'personacelular' => $pqr_correo->personacelular,
            'personacorreo' => $pqr_correo->personacorreo,
            'conjuntonombre' => $pqr_correo->conjuntonombre,
            'unidad' => $pqr_correo->bloquenombre.' - '.$pqr_correo->unidadnombre,
            'usuario' => 'Agente',
            'ruta' => NULL,
            'fase' => 'create'
        ];

        if($ruta) $data['ruta'] = $ruta;

        $copias = Organo::join('pqr_organos', 'pqr_organos.organo_id', 'organos.id')
            ->where('pqr_organos.pqr_id',$pqrs->id)
            ->select('organocorreo')->get();

        Mail::to($pqr_correo->organocorreo)->send(new PqrMailable($data));
        foreach($copias as $correo => $mail){
            Mail::to($mail->organocorreo)->send(new PqrMailable($data));
        }

        $data['usuario'] = 'Residente';
        $data['subject'] = '[Ticket #'.str_pad($pqr_correo->radicado,6,"0", STR_PAD_LEFT).'] - Su caso ha sido radicado';

        Mail::to($pqr_correo->personacorreo)->send(new PqrMailable($data));

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
            ->join('organos', 'organos.id', 'pqrs.organo_id')
            ->join('conjuntos', 'conjuntos.id', 'pqrs.conjuntoid')
            ->join('estado_pqrs', 'estado_pqrs.id', 'pqrs.estadoid')
            ->join('tipo_pqrs', 'tipo_pqrs.id', 'pqrs.tipopqrid')
            ->join('users', 'users.id', 'pqrs.userid')
            ->leftJoin('residentes', 'residentes.personaid', 'users.personaid')
            ->leftJoin('unidads', 'unidads.id', 'residentes.unidadid')
            ->leftJoin('bloques', 'bloques.id', 'unidads.bloqueid')
            ->select('pqrs.*', 'estadonombre', 'asunto', 'organonombre', 'tipopqrnombre', 'tipopqrtiempo','users.name', 'unidadnombre', 'bloquenombre')
            ->where('pqrs.id', $id)
            ->first();

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

        $fecha_plazo = $this->fecha_plazo($pqr->created_at, $pqr->tipopqrtiempo);
        $organos = Organo::join('pqr_organos', 'pqr_organos.organo_id', 'organos.id')
            ->join('pqrs', 'pqrs.id', 'pqr_organos.pqr_id')
            ->where('pqr_organos.pqr_id', $id)->get();

        return view('admin.pqr.edit', compact('pqr', 'flujos', 'adjuntos', 'comentarios', 'estados', 'organos', 'fecha_plazo'));
    }

    public function update(Request $request, $id){
        $pqrs = Pqr::find($id);

        $txt_correo = array(); $cont_evento = 0;

        $request->validate([
            'comentario'=>'max:400'
        ]);

        $txt = "El Ticket se actualizo exitosamente";

        if (null !== $request->get('estadoid')){
            if($request->get('estadoid') != $pqrs->estadoid){
                $pqrs->update([
                    'estadoid'=>$request->get('estadoid'),
                ]);

                //if($pqrs->estadoid != $request->get('estadoid')){
                    DetallePqr::create([
                        'pqrid' => $pqrs->id,
                        'estadoid' => $request->get('estadoid'),
                        'userid' => Auth::user()->id,
                        //'motivoid' => $request->get('motivo'),
                    ]);
                //}
                $estado = EstadoPqr::whereId($request->get('estadoid'))->first();
                $txt = "El estado se actualizo exitosamente";
                $cont_evento++;
                array_push($txt_correo, "El estado del ticket ha cambiado, ahora se encuentra [".$estado->estadonombre."]");
            }
        }

        $ruta = null;
        if ($request->hasfile('adjunto')){
            $this->validate($request, [
                'adjunto' => 'required|mimes:pdf,jpeg,png,jpg,svg|max:2048',
            ]);

            $destinationPath = public_path('storage/'.$request->get('conjuntoid').'/'.'pqrs');
            $file = $request->file('adjunto');

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
                'adjunto' => $filename,
                'userid' => Auth::user()->id,
            ]);

            $txt = "El archivo se subio exitosamente";
            $cont_evento++;
            array_push($txt_correo, "Se ha adjuntado un archivo al ticket");
        }

        if($request->get('comentario')){
            Comentario::create([
                'pqrid' => $pqrs->id,
                'comentario' => $request->get('comentario'),
                'userid' => Auth::user()->id,
            ]);
            $txt = "El mensaje se envio exitosamente";
            $cont_evento++;
            array_push($txt_correo, "Hay un comentario pendiente por leer");
        }

        if($cont_evento > 0){

            $pqr_correo = Pqr::join('tipo_pqrs', 'tipo_pqrs.id', 'pqrs.tipopqrid')
            ->join('organos', 'organos.id', 'pqrs.organo_id')
            ->join('conjuntos', 'conjuntos.id', 'pqrs.conjuntoid')
            ->join('asuntos', 'asuntos.id', 'pqrs.asuntoid')
            ->join('users', 'users.id', 'pqrs.userid')
            ->join('personas', 'personas.id', 'users.personaid')
            ->join('residentes', 'residentes.personaid', 'personas.id')
            ->join('unidads', 'unidads.id', 'residentes.unidadid')
            ->join('bloques', 'bloques.id', 'unidads.bloqueid')
            ->select('pqrs.id', 'tipopqrnombre', 'asunto', 'organonombre', 'organocorreo', 'mensaje', 'radicado', 'pqrs.created_at', 'personanombre', 'personacorreo', 'bloquenombre', 'unidadnombre')
            ->where('pqrs.id', $id)
            ->first();

            $data = [
                'id' => $pqr_correo->id,
                'tipo' => $pqr_correo->tipopqrnombre,
                'subject' => '[Ticket #'.str_pad($pqr_correo->radicado,6,"0", STR_PAD_LEFT).'] - Hubo una interacción en el ticket',
                'asunto' => $pqr_correo->asunto,
                'agente' => $pqr_correo->organonombre,
                'mensaje' => $pqr_correo->mensaje,
                'radicado' => 'TK-'.str_pad($pqr_correo->radicado,6,"0", STR_PAD_LEFT),
                'personanombre' => $pqr_correo->personanombre,
                'personacorreo' => $pqr_correo->personacorreo,
                'unidad' => $pqr_correo->bloquenombre.' - '.$pqr_correo->unidadnombre,
                'texto' => $txt_correo,
                'ruta' => NULL,
                'fase' => 'seguimiento'
            ];

            if($ruta) $data['ruta'] = $ruta;

            $user = User::find(Auth::user()->id);
            if ($user->hasRole('Residente')){
                $data['usuario'] = 'Agente';
                $copias = Organo::join('pqr_organos', 'pqr_organos.organo_id', 'organos.id')
                    ->where('pqr_organos.pqr_id',$id)
                    ->select('organocorreo')->get();

                Mail::to($pqr_correo->organocorreo)->send(new PqrMailable($data));
                foreach($copias as $correo => $mail){
                    Mail::to($mail->organocorreo)->send(new PqrMailable($data));
                }
             }else{
                $data['usuario'] = 'Residente';
                Mail::to($pqr_correo->personacorreo)->send(new PqrMailable($data));
            }

            return redirect()->route('admin.pqrs.edit', $pqrs->id)->with('info', $txt);

        }

        return redirect()->route('admin.pqrs.edit', $pqrs->id);
    }

    public function changeEstado(Request $request, $id)
    {
        $pqr = Pqr::find($id);
        $pqrs = Pqr::join('tipo_pqrs', 'tipo_pqrs.id', 'pqrs.tipopqrid')
            ->join('asuntos', 'asuntos.id', 'pqrs.asuntoid')
            ->join('organos', 'organos.id', 'pqrs.organo_id')
            ->where('pqrs.id', $id)
            ->first();

        $estado = 4; $estado_text = "cerrado";
        if($request->get('estadoid') == 4) {
            $estado = 1;
            $estado_text = "abierto";
        }
        $pqr->update([
            'estadoid'=> $estado,
        ]);

        $detalle_pqr = DetallePqr::create([
            'pqrid' => $pqr->id,
            'estadoid' => $estado,
            'userid' => Auth::user()->id,
            'motivoid' => $request->get('motivo'),
        ]);

        $motivo = DetallePqr::join('motivos','motivos.id','detalle_pqrs.motivoid')
            ->where('detalle_pqrs.id', $detalle_pqr->id)
            ->first();

        $data = [
            'id' => $pqrs->id,
            'tipo' => $pqrs->tipopqrnombre,
            'subject' => '[Ticket #'.str_pad($pqrs->radicado,6,"0", STR_PAD_LEFT).'] - El ticket ha sido cerrado',
            'asunto' => $pqrs->asunto,
            'agente' => $pqrs->organonombre,
            'mensaje' => $pqrs->mensaje,
            'motivo' => $motivo->motivo,
            'radicado' => 'TK-'.str_pad($pqrs->radicado,6,"0", STR_PAD_LEFT),
            'ruta' => NULL,
            'fase' => 'closed'
        ];

        $copias = Organo::join('pqr_organos', 'pqr_organos.organo_id', 'organos.id')
            ->where('pqr_organos.pqr_id',$id)
            ->select('organocorreo')->get();

        Mail::to($pqrs->organocorreo)->send(new PqrMailable($data));
        foreach($copias as $correo => $mail){
            Mail::to($mail->organocorreo)->send(new PqrMailable($data));
        }

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

    protected function esFestivo($time, $dias_festivos, $dias_saltados) {
		$w = date("w",$time); // dia de la semana en formato 0-6
		if(in_array($w, $dias_saltados)) return true;
		$j = date("j",$time); // dia en formato 1 - 31
		$n = date("n",$time); // mes en formato 1 - 12
		$y = date("Y",$time); // año en formato XXXX
		if(isset($dias_festivos[$y]) && isset($dias_festivos[$y][$n]) && in_array($j,$dias_festivos[$y][$n])) return true;
		return false;
	}


    protected function fecha_plazo($fecha, $dias_habiles) {
		$dias = array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
		$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		$dias_n = $dias_origin = $dias_habiles;
		$dias_contados = 0;
		$time = strtotime($fecha);
		$dia_time = 3600*24;

		$dias_festivos = array(
			"2021" =>  array(10 => array(18)
				,11 => array(1,15)
				,12 => array(8,25)) ,
			"2022" =>  array(1 => array(1,10)
				,3 => array(21)
                ,4 => array(14,15)
				,5 => array(30)
				,6 => array(20,27)
				,7 => array(4,20)
				,8 => array(15)
				,10 => array(17)
				,11 => array(7,14)
				,12 => array(8))
		);
		$dias_saltados = array(0,6);
		while($dias_n != 0) {
			$dias_contados++;
			$tiempoContado = $time+($dia_time*$dias_contados); // Sacamos el timestamp en la que estamos ahora mismo comprobando
			if($this->esFestivo($tiempoContado, $dias_festivos, $dias_saltados) == false)
				$dias_n--;
		}
		$FechaFinal = date("Ymd",$tiempoContado);

		$dia2 = substr($FechaFinal, 6, 2);
		$mes2 = substr($FechaFinal, 4, 2) * 1;
		$dia_semana2 = date('w', strtotime($FechaFinal) );
		$fecha_respuesta = $dias[$dia_semana2].", ".$dia2." de ".$meses[$mes2-1];
		return $fecha_respuesta;
	}



}
