<?php

namespace App\Http\Controllers\Admin;

use App\Exports\InvitadosExport;
use App\Http\Controllers\Controller;
use App\Imports\InvitadosImport;
use App\Models\Invitado;
use App\Models\Reserva;
use Illuminate\Http\Request;

use Excel;
use Illuminate\Support\Facades\Auth;

class InvitadoController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('can:admin.invitados.index')->only('index');
        $this->middleware('can:admin.invitados.create')->only('create', 'store');
        $this->middleware('can:admin.invitados.edit')->only('edit', 'update');
        //$this->middleware('can:admin.invitados.destroy')->only('destroy');
    }

    public function importForm($id){

        $reserva = Reserva::join("zonas","zonas.id", "=", "reservas.zonaid")
        ->join("unidads","unidads.id", "=", "reservas.unidadid")
        ->select("reservas.*", "zonanombre", "zonacompartida", "unidadnombre")
        ->where('reservas.id', $id)
         ->whereReservaestado(1)
         ->first();

         $invitados = Invitado::whereReservaid($id)->get();
         $total_invitados = $invitados->count();
         $i=1;

        return view('admin.invitado.import', compact('reserva', 'invitados', 'total_invitados', 'i'));
    }

    public function import(Request $request)
    {

        $reserva = Reserva::join("zonas","zonas.id", "=", "reservas.zonaid")
        ->join("unidads","unidads.id", "=", "reservas.unidadid")
        ->select("reservas.*", "zonanombre", "zonacompartida", "unidadnombre")
        ->where('reservas.id', $request->get('reservaid'))
         ->whereReservaestado(1)
         ->first();

        if ($request->hasfile('invitados')){
            $this->validate($request, [
                'invitados' => 'required|mimes:xls,xlsx',
            ]);
            session(['reservaid'=>$request->get('reservaid')]);
            $invitados = Invitado::whereReservaid($request->get('reservaid'));
            $invitados->delete();
            $import = new InvitadosImport();
            Excel::import($import, $request->file('invitados')->store('temp'));

            $invitados = Invitado::whereReservaid($request->get('reservaid'))->get();
            $total_invitados = $invitados->count();
            return view('admin.invitado.import', ['numRows'=>$import->getRowCount(), 'reserva'=>$reserva, 'invitados'=>$invitados, 'i'=>1, 'total_invitados'=>$total_invitados]);

        }

        $invitados = Invitado::whereReservaid($request->get('reservaid'))->get();
        $total_invitados = $invitados->count();
        return view('admin.invitado.import', ['reserva'=>$reserva, 'invitados'=>$invitados, 'i'=>1, 'total_invitados'=>$total_invitados]);
    }

    public function export($id)
    {
        $export = new InvitadosExport(['reservaid' => $id]);
        return Excel::download($export, 'invitados.xlsx');
    }

    public function destroy(Invitado $invitado)
    {
        $invitado->delete();

        $reserva = Reserva::join("zonas","zonas.id", "=", "reservas.zonaid")
        ->join("unidads","unidads.id", "=", "reservas.unidadid")
        ->select("reservas.*", "zonanombre", "zonacompartida", "unidadnombre")
        ->where('reservas.id', $invitado->reservaid)
         ->whereReservaestado(1)
         ->first();

         $invitados = Invitado::whereReservaid($invitado->reservaid)->get();
         $total_invitados = $invitados->count();
         $i=1;

        return view('admin.invitado.import', ['reserva'=>$reserva, 'invitados'=>$invitados, 'i'=>1, 'total_invitados'=>$total_invitados]);
    }
}
