<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\EventCalendar;
use App\Models\Item;
use App\Models\ItemTemp;
use App\Models\Reserva;
use App\Models\Unidad;
use App\Models\User;
use App\Models\Zona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservaController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('can:admin.reservas.index')->only('index');
        $this->middleware('can:admin.reservas.create')->only('create', 'store');
        $this->middleware('can:admin.reservas.edit')->only('edit', 'update');
        $this->middleware('can:admin.reservas.destroy')->only('destroy');
    }

    public function index()
    {
        $user = User::find(Auth::user()->id);
        if ($user->hasRole('Residente')){
            // $reservas = Reserva::join("zonas","zonas.id", "=", "reservas.zonaid")
            // ->join("residentes","residentes.unidadid", "=", "reservas.unidadid")
            // ->join("unidads","unidads.id", "=", "residentes.unidadid")
            // ->select("reservas.*", "zonanombre", "zonacompartida", "unidadnombre")
            // ->wherePersonaid(Auth::user()->personaid)
            //  //->whereReservaestado(1)
            //  ->orderBy('reservaestado', 'DESC')
            //  ->orderBy('reservafecha', 'ASC')
            //  ->get();
            $reservas = Book::join("zonas","zonas.id", "=", "books.zonaid")
                ->join("residentes","residentes.unidadid", "=", "books.unidadid")
                ->join("unidads","unidads.id", "=", "residentes.unidadid")
                ->select("books.*", "zonanombre", "zonacompartida", "unidadnombre")
                ->wherePersonaid(Auth::user()->personaid)
                //->whereReservaestado(1)
                ->orderBy('reservaestado', 'DESC')
                ->orderBy('reservafechaini', 'ASC')
                ->get();
        }else{
            $reservas = Reserva::join("zonas","zonas.id", "=", "reservas.zonaid")
             ->join("unidads","unidads.id", "=", "reservas.unidadid")
             ->select("reservas.*", "zonanombre", "zonacompartida", "unidadnombre")
             ->whereReservaestado(1)
             ->orderBy('reservaestado', 'DESC')
             ->orderBy('reservafecha', 'ASC')
             ->get();
        }
             return view('admin.reserva.index')->with('reservas', $reservas);
    }

    public function getCupoMaximo($id){

        $cupo = Zona::whereId($id)->select('zonacuporeservamax', 'zonatiemporeservamax')->first();

        return response()->json(['cupo' => $cupo], 200);

    }

    public function getNumHoras(Request $request){

        $fecha = date("Y-m-d",strtotime($request->get('fecha')));
        $fecha_sig = date("Y-m-d",strtotime($fecha."+ 1 days"));
        $fechainicio = date("Y-m-d H:i:s",strtotime($request->get('fecha')));
        $fechacierre = date("Y-m-d H:i:s",strtotime($fecha_sig.' '.$request->get('cierre')));
        $horas = null;

        if(Reserva::where('zonaid', $request->get('zonaid'))->where('reservafecha', $fecha)->doesntExist()){

            $horas = EventCalendar::where('event_calendars.zonaid', $request->get('zonaid'))
                ->where('event_calendars.start', '>=', $fechainicio)
                ->where('event_calendars.end', '<', $fechacierre)
                ->take($request->get('franjas'))->get()->count();
        }

        if(isset($horas)){
            return response()->json(['horas' => $horas], 200);
        }else{
            return "Lo sentimos, no hay disponibilidad de horarios en la fecha seleccionada";
        }
    }

    public function getHoras(Request $request){

        // $user = User::find(Auth::user()->id);
        // if ($user->hasRole('Residente')){
        //     $unidad = Unidad::join('residentes','residentes.unidadid', 'unidads.id')
        //     ->where('residentes.personaid', $user->personaid)
        //     ->select('unidads.id')->first();
        // }else{
        //     $unidad = Unidad::join('bloques','bloques.id', 'unidads.bloqueid')
        //     ->whereIn('bloques.conjuntoid', session('dependencias'))
        //     ->select('unidads.id')->get();
        // }

        $unidad = Unidad::whereId($request->get('unidadid'))->select('unidads.id')->first();

        $horas = EventCalendar::where('event_calendars.zonaid', $request->get('zonaid'))
        ->join("zonas","zonas.id", "=", "event_calendars.zonaid")
        ->leftJoin('reservas as r', function ($join) {
            $join->on('r.zonaid', '=', 'zonas.id')
                ->on('r.reservafecha', '=', 'event_calendars.fecha')
                ->on('r.reservahora', '=', 'event_calendars.hora')
                ->where('r.reservaestado', '=', 1);
        })
        ->leftJoin('reservas as r2', function ($join) use ($unidad) {
            $join->on('r2.zonaid', '=', 'zonas.id')
                ->on('r2.reservafecha', '=', 'event_calendars.fecha')
                ->where('r2.reservaestado', '=', 1)
                ->where('r2.unidadid', '=', $unidad->id);
        })
        ->select(EventCalendar::raw('event_calendars.id, zonaaforomax, event_calendars.hora, event_calendars.start, event_calendars.end, SUM(coalesce(r.reservacupos,0)) as reservas, COUNT(r2.id) as contador '))
        ->where('event_calendars.fecha', $request->get('fecha'))
        ->where('event_calendars.start', '>', date('Y-m-d H:i:s'))
        ->groupBy('event_calendars.id', 'zonaaforomax', 'event_calendars.hora')
        //->having(Zona::raw('zonaaforomax-reservas'), '>=', $request->get('reservacupos'))
        //->having(Zona::raw('contador'), '<', $request->get('reservadiariamax'))
        ->orderBy('event_calendars.start', 'ASC')
        ->get();

        if(isset($horas)){
            return response()->json(['horas' => $horas], 200);
        }else{
            return "Lo sentimos, no hay disponibilidad de horarios en la fecha seleccionada";
        }

    }

     public function create()
    {
        $zona = Zona::all()->pluck('zonanombre', 'id');
        $zona->prepend('Seleccione la zona', '');

        $user = User::find(Auth::user()->id);
        if ($user->hasRole('Residente')){
            $unidad = Unidad::join('residentes','residentes.unidadid', 'unidads.id')
            ->where('residentes.personaid', $user->personaid)
            ->pluck('unidadnombre', 'unidads.id');
        }else{
            $unidad = Unidad::all();
        }

        return view('admin.reserva.create', compact('zona', 'unidad'));
    }

    public function carrito(Request $request)
    {
        $request->validate([
            'zonaid'=>'required',
            'unidadid'=>'required',
            'reservacupos'=>'required',
            'franja'=>'required',
            'fecha'=>'required'
        ]);

        $zona = Zona::find($request->get('zonaid'));
        $reservas_actuales = Reserva::whereZonaid($request->get('zonaid'))
            ->whereUnidadid($request->get('unidadid'))
            ->whereReservafecha($request->get('fecha'))
            ->count();

        $fecha = date("Y-m-d",strtotime($request->get('fecha')));
        $hora = date("H",strtotime($request->get('fecha')));
        $fechaInicial = date("Y-m-d H:i:s",strtotime($request->get('fecha')));
        $FechaFinal = date("Y-m-d H:i:s",strtotime($fechaInicial."+ ".$request->get('franja')." hours"));

        $permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $user = User::find(Auth::user()->id);
        if ($user->hasRole('Residente')){
            $codigo = "R-".substr(str_shuffle($permitted_chars), 0, 3)."-".date('His');
        }else{
            $codigo = "A-".substr(str_shuffle($permitted_chars), 0, 3)."-".date('His');
        }

        $book = Book::create([
            'zonaid'=> $request->get('zonaid'),
            'unidadid'=> $request->get('unidadid'),
            'reservacodigo'=> $codigo,
            'reservacupos'=> $request->get('reservacupos'),
            'reservafechaini'=>$fechaInicial,
            'reservafechafin'=>$FechaFinal,
            'valor'=> $zona->zonaprecio * $request->get('franja'),
            'reservaestado'=> 1,
        ]);

        for($i=0;$i<$request->get('franja');$i++){
            $evento = EventCalendar::whereZonaid($request->get('zonaid'))
                ->whereFecha($fecha)
                ->whereHora($hora + $i.":00:00")
                ->first();

            Reserva::create([
                'reservaid'=> $book->id,
                'zonaid'=> $request->get('zonaid'),
                'unidadid'=> $request->get('unidadid'),
                'reservacodigo'=> $codigo,
                'reservacupos'=> $request->get('reservacupos'),
                'reservafecha'=> $evento->fecha,
                'reservahora'=> $evento->hora,
                'reservahorafin'=> date('H:i:s', strtotime($evento->end)),
                'valor'=> $zona->zonaprecio,
                'reservaestado'=> 1,
            ]);

             $evento->update([
                 'backgroundColor'=> '#EEA214',
             ]);
        }

        return redirect()->route('admin.reservas.index', $request->get('zonaid'))->with('info','la reserva se guardo de forma exitosa');


    }

    public function store(Request $request)
    {

        $permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $user = User::find(Auth::user()->id);

        if ($user->hasRole('Residente')){
            $codigo = "R-".substr(str_shuffle($permitted_chars), 0, 3)."-".date('His');
        }else{
            $codigo = "A-".substr(str_shuffle($permitted_chars), 0, 3)."-".date('His');
        }
        $evento = EventCalendar::whereId($request->get('calendarid'))->first();

        $zona = Zona::find($request->get('zonaid'));
        $book = Book::create([
            'zonaid'=> $request->get('zonaid'),
            'unidadid'=> $request->get('unidadid'),
            'reservacodigo'=> $codigo,
            'reservacupos'=> $request->get('reservacupos'),
            'reservafechaini'=>$evento->fecha." ".$evento->hora,
            'reservafechafin'=>$evento->end,
            'valor'=> $zona->zonaprecio * $request->get('franja'),
            'reservaestado'=> 1,
        ]);

        Reserva::create([
            'reservaid'=> $book->id,
            'zonaid'=> $request->get('zonaid'),
            'unidadid'=> $request->get('unidadid'),
            'reservacodigo'=> $codigo,
            'reservacupos'=> $request->get('reservacupos'),
            'reservafecha'=> $evento->fecha,
            'reservahora'=> $evento->hora,
            'reservahorafin'=> date('H:i:s', strtotime($evento->end)),
            'valor'=> $zona->zonaprecio,
            'reservaestado'=> 1,
        ]);

        $evento->update([
            'backgroundColor'=> '#EEA214',
        ]);

        return response()->json(['info' => 'La reserva se realizo de forma exitosa'], 200);
        //return redirect()->route('admin.reservas.index')->with('info','La reserva se realizo de forma exitosa');

    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {

        $user = User::find(Auth::user()->id);
        if ($user->hasRole('Residente')){
            $unidad = Unidad::join('residentes','residentes.unidadid', 'unidads.id')
            ->where('residentes.personaid', $user->personaid)
            ->pluck('unidadnombre', 'unidads.id');
            $zona = Zona::whereId($id)->pluck('zonanombre', 'id');

        }else{
            $unidad = Unidad::join('bloques', 'bloques.id', '=', 'unidads.bloqueid')
                ->whereIn('bloques.conjuntoid', session('dependencias'))->pluck('unidadnombre', 'unidads.id');
            $zona = Zona::whereId($id)->pluck('zonanombre', 'id');

        }
        $zonareserva = Zona::whereId($id)
        ->select('zonaaforomax', 'zonanombre','zonacompartida', 'zonahoraapertura', 'zonahoracierre', 'zonafranjatiempo', 'zonacuporeservamax', 'zonatiemporeservamax', 'zonareservadiariamax', 'zonaprecio')->first();
        //$zona->prepend('Seleccione la zona', '');

        //$fechas = Book::whereZonaid($id)->select('reservafechaini')->get();
        $fechas = EventCalendar::whereZonaid($id)
        ->where('start', '>', date('Y-m-d H:i:s'))
        ->whereNotIn('fecha', Reserva::select('reservafecha')->where('zonaid', '=', $id)->where('reservafecha', '>=', date('Y-m-d'))->get()->toArray())
        ->select('fecha')
        ->orderBy('fecha')
        ->distinct()->get();


        return view('admin.reserva.edit', compact('zona', 'unidad', 'zonareserva', 'fechas'));
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy(Request $request, $id)
    {
        $reserva = Book::find($id);
        $reservafechaini = $reserva->reservafechaini;
        $reservafechafin = $reserva->reservafechafin;
        $reserva->delete();

        $reservafecha = date('Y-m-d', strtotime($request->get('reservafechaini')));
        $reservahora = date('H:i:s', strtotime($request->get('reservafechaini')));
        $reserva_cont = Reserva::whereReservaid($id)->count();

        // $reserva_cont = Reserva::whereZonaid($request->get('zonaid'))
        // ->whereReservafecha($request->get('reservafecha'))
        // ->whereReservahora($request->get('reservahora'))
        // ->count();

        if($reserva_cont <= 0){
            EventCalendar::whereZonaid($request->get('zonaid'))
            ->where('start', '>=', $reservafechaini)
            ->where('end', '<=', $reservafechafin)
            ->update([
                'backgroundColor'=> '#3788D8',
            ]);
        }

        return redirect()->route('admin.reservas.index')->with('info','La reserva fue eliminada exitosamente');
    }
}
