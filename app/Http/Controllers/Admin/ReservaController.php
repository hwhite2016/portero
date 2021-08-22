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
             ->wherePersonaid(Auth::user()->personaid)
             ->orderBy('reservafecha', 'ASC')
             ->get();
             return view('admin.reserva.index')->with('reservas', $reservas);
    }

    public function getCupoMaximo($id){

        $cupo = Zona::whereId($id)->select('zonacuporeservamax', 'zonatiemporeservamax')->first();

        return response()->json(['cupo' => $cupo], 200);

    }

    public function getHoras(Request $request){

        $horas = EventCalendar::where('event_calendars.zonaid', $request->get('zonaid'))
        ->join("zonas","zonas.id", "=", "event_calendars.zonaid")
        ->leftJoin('reservas', function ($join) {
            $join->on('reservas.zonaid', '=', 'zonas.id')
                ->on('reservas.reservafecha', '=', 'event_calendars.fecha')
                ->on('reservas.reservahora', '=', 'event_calendars.hora');
        })
        ->select(EventCalendar::raw('zonaaforomax, event_calendars.hora, SUM(coalesce(reservacupos,0)) as reservas'))
        ->where('event_calendars.fecha', $request->get('fecha'))
        ->where(Zona::raw('zonaaforomax-coalesce(reservacupos,0)'), '>=', $request->get('reservacupos'))
        ->groupBy('zonaaforomax', 'event_calendars.hora')
        ->get();

        if(isset($horas)){
            return response()->json(['horas' => $horas], 200);
        }else{
            return "Lo seentimos, no hay disponibilidad de horarios en la fecha seleccionada";
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
            $unidad = Unidad::all()->pluck('unidadnombre', 'unidads.id');
            $zona = Zona::find($id)->pluck('zonanombre', 'id');

        }
        $zonareserva = Zona::whereId($id)->select('zonacuporeservamax', 'zonatiemporeservamax')->first();
        //$zona->prepend('Seleccione la zona', '');

        return view('admin.reserva.edit', compact('zona', 'unidad', 'zonareserva'));
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
