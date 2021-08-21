<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventCalendar;
use Illuminate\Http\Request;

class EventCalendarController extends Controller
{

    public function index(Request $request)
    {

        $eventos = EventCalendar::where('event_calendars.zonaid', $request->get('zonaid'))
        ->leftJoin('reservas', function ($join) {
            $join->on('reservas.zonaid', '=', 'event_calendars.zonaid')
                ->on('reservas.reservafecha', '=', 'event_calendars.fecha')
                ->on('reservas.reservahora', '=', 'event_calendars.hora');
        })
        ->select(EventCalendar::raw('event_calendars.id, title, start, end, backgroundColor, SUM(coalesce(reservacupos,0)) as reservas'))
        ->groupBy('event_calendars.id', 'title', 'start', 'end', 'backgroundColor')
        ->get();


        //return response()->json(['eventos' => $eventos], 200);
        $chain = '[';
        foreach($eventos as $evento){
            if ($chain == '['){
                $chain .= '{ "id": "'.$evento->id.'", "title": "Reservas: '.$evento->reservas.'", "start": "'.$evento->start.'", "end": "'.$evento->end.'", "backgroundColor": "'.$evento->backgroundColor.'" }';
            }else{
                $chain .= ',{ "id": "'.$evento->id.'", "title": "Reservas: '.$evento->reservas.'", "start": "'.$evento->start.'", "end": "'.$evento->end.'", "backgroundColor": "'.$evento->backgroundColor.'" }';
            }
        }
        $chain .= ']';
        return $chain;
    }

     public function create()
    {
        //
    }

     public function store(Request $request)
    {
        $horaEntrada = $request->get('zonafranjatiempo');
        $v_HorasPartes = explode(":", $horaEntrada);
        $minutosTotales= ($v_HorasPartes[0] * 60) + $v_HorasPartes[1];

        $hora = strtotime(substr($request->get('start'), 0, -6)." +".$minutosTotales." minutes");
        $end =  date('Y-m-d H:i:s', $hora);

        if (!EventCalendar::whereZonaid($request->get('zonaid'))->whereStart(substr($request->get('start'), 0, -6))->exists()) {
            $eventCalendar = EventCalendar::create([
                'zonaid' => $request->get('zonaid'),
                'title' => 'Disponible',
                'fecha' => substr($request->get('start'), 0, -15),
                'hora' => substr($request->get('start'), 11, -6),
                'start' => substr($request->get('start'), 0, -6),
                'end' => $end
            ]);
            return $eventCalendar->id;
        }else{
            return null;
        }


    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {

        if (EventCalendar::join('reservas', function ($join) {
            $join->on('reservas.zonaid', '=', 'event_calendars.zonaid')
                ->on('reservas.reservafecha', '=', 'event_calendars.fecha')
                ->on('reservas.reservahora', '=', 'event_calendars.hora');
            })->where('event_calendars.id', $id)->exists()) {

            return null;
        }else{
            $eventCalendar = EventCalendar::find($id);
            $eventCalendar->delete();
            return $eventCalendar->id;
        }

    }
}
