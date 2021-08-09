<?php

namespace App\Http\Controllers\Admin;

use App\Events\EntregaEvent;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Entrega;
use App\Models\TipoEntrega;
use App\Models\Unidad;
use App\Models\Conjunto;
use App\Models\Residente;
use App\Models\User;
use App\Notifications\EntregaNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;

class EntregaController extends Controller
{
    use Notifiable;

    public function __construct(){
        $this->middleware('auth');
        $this->middleware('can:admin.entregas.index')->only('index');
        $this->middleware('can:admin.entregas.create')->only('create', 'store');
        $this->middleware('can:admin.entregas.edit')->only('edit', 'update');
        $this->middleware('can:admin.entregas.destroy')->only('destroy');
    }

    public function index()
    {

        $entregas = Entrega::join("unidads","unidads.id", "=", "entregas.unidadid")
             ->join('bloques','bloques.id','=','unidads.bloqueid')
             ->join('conjuntos','conjuntos.id','=','bloques.conjuntoid')
             ->join('tipo_entregas','tipo_entregas.id','=','entregas.tipoentregaid')
             ->join('residentes','residentes.id','=','entregas.entregadestinatario')
             ->join('personas','personas.id','=','residentes.personaid')
             ->select(Entrega::raw('entregas.id, conjuntonombre, bloquenombre, unidadnombre, tipoentregaid, tipoentreganombre, entregaempresa, entregareceptor, personanombre, entregaobservacion, entregafechaentrega, entregaestado, entregas.created_at'))
             ->where('entregafechaentrega', NULL)
             ->whereIn('conjuntos.id', session('dependencias'))
             ->orderBy('entregas.created_at', 'DESC')
             ->get();
             return view('admin.entrega.index')->with('entregas', $entregas);
    }

    public function getEntregas()
    {

        $entregas = Entrega::join("unidads","unidads.id", "=", "entregas.unidadid")
             ->join('bloques','bloques.id','=','unidads.bloqueid')
             ->join('conjuntos','conjuntos.id','=','bloques.conjuntoid')
             ->join('tipo_entregas','tipo_entregas.id','=','entregas.tipoentregaid')
             ->join('residentes','residentes.id','=','entregas.entregadestinatario')
             ->join('personas','personas.id','=','residentes.personaid')
             ->select(Entrega::raw('entregas.id, conjuntonombre, bloquenombre, unidadnombre, tipoentregaid, tipoentreganombre, entregaempresa, entregareceptor, personanombre, entregaobservacion, entregafechaentrega, entregaestado,entregas.created_at'))
             ->where('entregafechaentrega', NULL)
             ->where('residentes.personaid', Auth::user()->personaid)
             ->whereIn('conjuntos.id', session('dependencias'))
             ->orderBy('entregas.created_at', 'DESC')
             ->get();
             return view('admin.entrega.seguimiento')->with('entregas', $entregas);
    }

    public function getInfoPersona($id){

        $nombre = Residente::join('personas','personas.id','=','residentes.personaid')
        ->whereUnidadid($id)
        ->select('residentes.id', 'personanombre')
        ->get();
        if(isset($nombre)){
           return response()->json(['persona' => $nombre], 200);
        }else{
            return "No se encontraron resultados" . $id ;
        }
    }

    public function create(Request $request)
    {
        $tipo_entregas = Tipoentrega::all()->pluck('tipoentreganombre', 'id');
        $conjuntos = Conjunto::whereIn('conjuntos.id', session('dependencias'))->pluck('conjuntonombre', 'id');

        $unidads = Unidad::join('bloques','bloques.id','=','unidads.bloqueid')
            ->select(
            Unidad::raw("CONCAT(bloquenombre,' - ',unidadnombre) AS unidad"),'unidads.id')
            ->whereIn('conjuntoid', session('dependencias'))
            ->orderBy('unidad','ASC')
            ->pluck('unidad', 'unidads.id');

        $unidads->prepend('Seleccione la unidad', '');

        return view('admin.entrega.create', compact('tipo_entregas', 'conjuntos', 'unidads'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'conjuntoid'=>'required',
            'unidadid'=>'required',
            'tipoentregaid' => 'required',
            'entregadestinatario' => 'required'
        ]);

        $recepcion = entrega::create([
            'unidadid'=>$request->get('unidadid'),
            'tipoentregaid'=>$request->get('tipoentregaid'),
            'entregaempresa'=>$request->get('entregaempresa'),
            'entregareceptor'=>Auth::user()->name,
            'entregadestinatario'=>$request->get('entregadestinatario'),
            'entregaobservacion'=>$request->get('entregaobservacion'),
        ]);

        $entrega = Entrega::join('tipo_entregas','tipo_entregas.id','=','entregas.tipoentregaid')
            ->join('residentes','residentes.id','=','entregas.entregadestinatario')
             ->join('personas','personas.id','=','residentes.personaid')
             ->select(Entrega::raw('entregas.id, entregas.unidadid, tipoentregaid, tipoentreganombre as title, tipoentregaicono, entregaempresa as empresa, entregareceptor, entregadestinatario, personanombre, entregaobservacion, entregas.created_at'))
             ->where('entregas.id', $recepcion->id)->first();

        //$entrega->residentes()->sync($request->residentes);


        //    User::join('residentes','residentes.personaid','=','users.personaid')
        //     ->whereUnidadid($request->get('unidadid'))
        //     ->select(Residente::raw('users.id'))
        //     ->each(function(User $user) use ($entrega){
        //         $user->notify(new EntregaNotification($entrega));
        //     });

        event(new EntregaEvent($entrega));

        return redirect()->route('admin.entregas.index')->with('info','La entrega fue agregada de forma exitosa');
    }

    public function show($id)
    {
        $user = User::find(Auth::user()->id);
        if ($user->hasRole('Seguridad')){
            $entregas = Entrega::join("unidads","unidads.id", "=", "entregas.unidadid")
            ->join('bloques','bloques.id','=','unidads.bloqueid')
            ->join('conjuntos','conjuntos.id','=','bloques.conjuntoid')
            ->join('tipo_entregas','tipo_entregas.id','=','entregas.tipoentregaid')
            ->join('residentes','residentes.id','=','entregas.entregadestinatario')
            ->join('personas','personas.id','=','residentes.personaid')
            ->select(Entrega::raw('entregas.id, conjuntonombre, bloquenombre, unidadnombre, tipoentregaid, tipoentreganombre, entregaempresa, entregareceptor, personanombre, entregaobservacion, entregafechaentrega, entregaestado, entregas.created_at'))
            ->where('entregas.entregafechaentrega', $id, NULL)
            ->whereIn('conjuntos.id', session('dependencias'))
            ->orderBy('entregas.created_at', 'DESC')
            ->get();
            return view('admin.entrega.index')->with('entregas', $entregas);
        }else{
            $entregas = Entrega::join("unidads","unidads.id", "=", "entregas.unidadid")
            ->join('bloques','bloques.id','=','unidads.bloqueid')
            ->join('conjuntos','conjuntos.id','=','bloques.conjuntoid')
            ->join('tipo_entregas','tipo_entregas.id','=','entregas.tipoentregaid')
            ->join('residentes','residentes.id','=','entregas.entregadestinatario')
            ->join('personas','personas.id','=','residentes.personaid')
            ->select(Entrega::raw('entregas.id, conjuntonombre, bloquenombre, unidadnombre, tipoentregaid, tipoentreganombre, entregaempresa, entregareceptor, personanombre, entregaobservacion, entregafechaentrega,entregaestado,entregas.created_at'))
            ->where('entregas.entregaestado', $id, 0)
            ->whereIn('conjuntos.id', session('dependencias'))
            ->orderBy('entregas.created_at', 'DESC')
            ->get();
            return view('admin.entrega.seguimiento')->with('entregas', $entregas);

        }
    }

    public function edit($id)
    {
        $entrega = Entrega::find($id);
        $tipo_entregas = Tipoentrega::all()->pluck('tipoentreganombre', 'id');
        $conjuntos = Conjunto::whereIn('conjuntos.id', session('dependencias'))->pluck('conjuntonombre', 'id');
        $unidads = Unidad::join('bloques','bloques.id','=','unidads.bloqueid')
            ->select(
            Unidad::raw("CONCAT(bloquenombre,' - ',unidadnombre) AS unidad"),'unidads.id')
            ->whereIn('conjuntoid', session('dependencias'))
            ->orderBy('unidad','ASC')
            ->pluck('unidad', 'unidads.id');

        //$unidads->prepend('Seleccione la unidad', '');

        return view('admin.entrega.edit', compact('entrega', 'tipo_entregas', 'conjuntos', 'unidads'));

    }

    public function update(Entrega $entrega)
    {
        $user = User::find(Auth::user()->id);
        if ($user->hasRole('Seguridad')){
            $entrega->update(['entregafechaentrega'=> now()]);
            return redirect()->route('admin.entregas.index')->with('info','La entrega se hizo de forma exitosa');
        }else{
            $entrega->update(['entregaestado'=> 1]);
            return redirect()->route('admin.seguimiento.index')->with('info','La confirmación de la entrega fue exitosa');
        }
    }

    public function destroy($id)
    {
        $entrega = Entrega::find($id);
        $entrega->delete();

        return redirect()->route('admin.entregas.show', $entrega->unidadid)->with('info','La entrega fue eliminada exitosamente');
    }
}
