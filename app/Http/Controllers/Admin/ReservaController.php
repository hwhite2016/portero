<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventCalendar;
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
        $reservas = Reserva::join("zonas","zonas.id", "=", "reservas.zonaid")
            ->join("residentes","residentes.unidadid", "=", "reservas.unidadid")
            ->join("unidads","unidads.id", "=", "residentes.unidadid")
            ->select("reservas.*", "zonanombre", "unidadnombre")
            ->wherePersonaid(Auth::user()->personaid)
             ->whereReservaestado(1)
             ->orderBy('reservafecha', 'ASC')
             ->get();
             return view('admin.reserva.index')->with('reservas', $reservas);
    }

    public function getCupoMaximo($id){

        $cupo = Zona::whereId($id)->select('zonacuporeservamax', 'zonatiemporeservamax')->first();

        return response()->json(['cupo' => $cupo], 200);

    }

    public function getHoras(Request $request){

        $user = User::find(Auth::user()->id);
        if ($user->hasRole('Residente')){
            $unidad = Unidad::join('residentes','residentes.unidadid', 'unidads.id')
            ->where('residentes.personaid', $user->personaid)
            ->select('unidads.id')->first();
        }

        $horas = EventCalendar::where('event_calendars.zonaid', $request->get('zonaid'))
        ->join("zonas","zonas.id", "=", "event_calendars.zonaid")
        ->leftJoin('reservas', function ($join) {
            $join->on('reservas.zonaid', '=', 'zonas.id')
                ->on('reservas.reservafecha', '=', 'event_calendars.fecha')
                ->on('reservas.reservahora', '=', 'event_calendars.hora');
        })
        ->select(EventCalendar::raw('event_calendars.id, zonaaforomax, event_calendars.start, event_calendars.end, SUM(coalesce(reservacupos,0)) as reservas'))
        ->where('event_calendars.fecha', $request->get('fecha'))
        ->where('event_calendars.start', '>', date('Y-m-d H:i:s'))
        ->groupBy('event_calendars.id', 'zonaaforomax', 'event_calendars.hora')
        ->having(Zona::raw('zonaaforomax-reservas'), '>=', $request->get('reservacupos'))
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

        Reserva::create([
            'zonaid'=> $request->get('zonaid'),
            'unidadid'=> $request->get('unidadid'),
            'reservacodigo'=> $codigo,
            'reservacupos'=> $request->get('reservacupos'),
            'reservafecha'=> $evento->fecha,
            'reservahora'=> $evento->hora,
            'reservahorafin'=> date('H:i:s', strtotime($evento->end)),
            'valor'=> $request->get('precio'),
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
            $unidad = Unidad::all()->pluck('unidadnombre', 'id');
            $zona = Zona::whereId($id)->pluck('zonanombre', 'id');

        }
        $zonareserva = Zona::whereId($id)
        ->select('zonaaforomax', 'zonafranjatiempo', 'zonacuporeservamax', 'zonatiemporeservamax', 'zonaprecio')->first();
        //$zona->prepend('Seleccione la zona', '');

        return view('admin.reserva.edit', compact('zona', 'unidad', 'zonareserva'));
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy(Request $request, $id)
    {

        $reserva = Reserva::find($id);
        $reserva->delete();

        $reserva_cont = Reserva::whereZonaid($request->get('zonaid'))
        ->whereReservafecha($request->get('reservafecha'))
        ->whereReservahora($request->get('reservahora'))
        ->count();

        if($reserva_cont <= 0){
            $evento = EventCalendar::whereZonaid($request->get('zonaid'))
            ->whereFecha($request->get('reservafecha'))
            ->whereHora($request->get('reservahora'))
            ->first();

            $evento->update([
                'backgroundColor'=> '#3788D8',
            ]);
        }

        return redirect()->route('admin.reservas.index')->with('info','La reserva fue cancelada exitosamente');
    }
}
