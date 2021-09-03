<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Conjunto;
use App\Models\EventCalendar;
use App\Models\User;
use App\Models\Zona;
use App\Models\ZonaHorario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

class ZonaController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('can:admin.zonas.index')->only('index');
        $this->middleware('can:admin.zonas.create')->only('create', 'store');
        $this->middleware('can:admin.zonas.edit')->only('edit', 'update');
        $this->middleware('can:admin.zonas.destroy')->only('destroy');
    }

    public function index()
    {
        $zonas = Zona::join("conjuntos","conjuntos.id", "=", "zonas.conjuntoid")
             ->join('barrios','barrios.id','=','conjuntos.barrioid')
             ->select(Zona::raw('zonas.id, barrionombre, conjuntonombre, zonas.*'))
             ->whereIn('conjuntos.id', session('dependencias'))
             ->orderBy('zonas.zonanombre', 'ASC')
             ->get();
             return view('admin.zona.index')->with('zonas', $zonas);
    }

    public function zonacomun()
    {
        $zonas = Zona::join("conjuntos","conjuntos.id", "=", "zonas.conjuntoid")
             ->join('barrios','barrios.id','=','conjuntos.barrioid')
             ->select(Zona::raw('zonas.id, barrionombre, conjuntonombre, zonas.*'))
             ->whereIn('conjuntos.id', session('dependencias'))
             ->orderBy('zonas.zonanombre', 'ASC')
             ->get();
             return view('admin.zona.zonacomun')->with('zonas', $zonas);
    }

    public function terminosModal($id)
    {
        $terminos = Zona::select(Zona::raw('zonas.id, zonaterminos'))
            ->whereId($id)
            ->first();
        return $terminos;
    }

    public function create()
    {
        $conjuntos = Conjunto::whereIn('conjuntos.id', session('dependencias'))->pluck('conjuntonombre', 'id');
        return view('admin.zona.create')->with('conjuntos',$conjuntos);
    }

    public function store(Request $request)
    {
        $request->validate([
            'conjuntoid'=>'required',
            'zonanombre'=>'required|min:3|max:50',
            'zonareservable'=>'required',
            'zonadescripcion' => 'max:300',
            'zonaterminos' => 'max:1800',
            'zonanombre' => 'unique:zonas,zonanombre,NULL,id,conjuntoid,' . $request->get('conjuntoid')
        ]);

        if ($request->hasfile('zonaimagen')){
            $this->validate($request, [
                'zonaimagen' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',
            ]);

            $destinationPath = public_path('storage/'.$request->get('conjuntoid').'/'.'zonas');
            $file = $request->file('zonaimagen');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777,true);
            }
            $filename_db = $request->get('conjuntoid').'/'.'zonas/'.date('YmdHis').'.'.$file->getClientOriginalExtension();
            $filename = date('YmdHis').'.'.$file->getClientOriginalExtension();
            Image::make($file->getRealPath())->resize(350, 120, function ($constraint) {
            $constraint->aspectRatio();})->save($destinationPath.'/'.$filename);

            //$destinationPath = public_path('/storage');
            //$file = $request->file('zonaimagen');
            //$filename = 'zonas/'.date('YmdHis').'.'.$file->getClientOriginalExtension();

            //Image::make($file->getRealPath())->resize(350, 120, function ($constraint) {
            //$constraint->aspectRatio();})->save($destinationPath.'/'.$filename);
         }else{
            $filename = 'images/zonacomun.png';
        }

        $zonas = Zona::create([
            'conjuntoid' => $request->get('conjuntoid'),
            'zonanombre' => $request->get('zonanombre'),
            'zonadescripcion' => $request->get('zonadescripcion'),
            'zonaterminos' => $request->get('zonaterminos'),
            'zonareservable' => $request->get('zonareservable'),
            'zonahoraapertura' => $request->get('zonaapertura'),
            'zonahoracierre' => $request->get('zonahoracierre'),
            'zonafranjatiempo' => $request->get('zonafranjatiempo'),
            'zonaaforomax' => $request->get('zonaaforomax'),
            'zonacompartida' => $request->get('zonacompartida'),
            'zonacuporeservamax' => $request->get('zonacuporeservamax'),
            'zonatiemporeservamax' => $request->get('zonatiemporeservamax'),
            'zonareservadiariamax' => $request->get('zonareservadiariamax'),
            'zonaprecio' => $request->get('zonaprecio'),
            'zonamorosos' => $request->get('zonamorosos'),
            'zonaimagen' => $filename_db
        ]);

        $conjuntos = Conjunto::whereIn('conjuntos.id', session('dependencias'))->pluck('conjuntonombre', 'id');
        return view('admin.zona.edit')->with('zona',$zonas)->with('conjuntos',$conjuntos)->with('info','La zona comun fue agregada de forma exitosa');

        //return redirect()->route('admin.zonas.show', $zonas->conjuntoid)->with('info','La zona comun fue agregada de forma exitosa');

    }

    public function show($id)
    {
        $zonas = Zona::join("conjuntos","conjuntos.id", "=", "zonas.conjuntoid")
             ->join('barrios','barrios.id','=','conjuntos.barrioid')
             ->select(Zona::raw('zonas.id, barrionombre, conjuntonombre, zonas.*'))
              ->where('zonas.conjuntoid', '=', $id)
             ->whereIn('conjuntos.id', session('dependencias'))
             ->orderBy('zonanombre', 'ASC')
             ->get();

        return view('admin.zona.index')->with('zonas', $zonas);

    }

    public function calendario($id)
    {
        $zona = Zona::find($id);
        $zonaHorario = ZonaHorario::whereZonaid($id)->get();
        return view('admin.zona.calendario', compact('zona', 'zonaHorario'));
    }

    public function edit($id)
    {
        $zona = Zona::find($id);
        $conjuntos = Conjunto::whereIn('conjuntos.id', session('dependencias'))->pluck('conjuntonombre', 'id');

        return view('admin.zona.edit', compact('zona','conjuntos'));
    }

    public function update(Request $request, $id)
    {
        $zona = Zona::find($id);
        $validar_update = $zona->id > 0 ? $zona->id : "NULL";

            $request->validate([
                'conjuntoid'=>'required',
                'zonanombre'=>'required|min:3|max:50',
                'zonareservable'=>'required',
                'zonadescripcion' => 'max:300',
                'zonaterminos' => 'max:1800',
                'zonanombre' => 'unique:zonas,zonanombre,' . $validar_update . ',id,conjuntoid,' . $request->get('conjuntoid')
            ]);

            if ($request->hasfile('zonaimagen')){
                $this->validate($request, [
                    'zonaimagen' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',
                ]);

                $destinationPath = public_path('storage/'.$request->get('conjuntoid').'/'.'zonas');
                $file = $request->file('zonaimagen');

                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777,true);
                }

                $filename = date('YmdHis').'.'.$file->getClientOriginalExtension();
                $filename_db = $request->get('conjuntoid').'/'.'zonas/'.date('YmdHis').'.'.$file->getClientOriginalExtension();
                $fullpath_old = $destinationPath.'/'.$zona->zonaimagen;
                Image::make($file->getRealPath())->resize(350, 120, function ($constraint) {
                $constraint->aspectRatio();})->save($destinationPath.'/'.$filename);

                //$destinationPath = public_path('/storage');
                //$file = $request->file('zonaimagen');
                //$filename = 'zonas/'.date('YmdHis').'.'.$file->getClientOriginalExtension();
                //$fullpath_old = $destinationPath.'/'.$zona->zonaimagen;
                //Image::make($file->getRealPath())->resize(350, 120, function ($constraint) {
                //$constraint->aspectRatio();})->save($destinationPath.'/'.$filename);

                if((File::exists($fullpath_old)) && ($zona->zonaimagen <> 'images/zonacomun.png')) {
                    File::delete($fullpath_old);
                }
                $zona->zonaimagen = $filename_db;
            }

            $zona->conjuntoid = $request->get('conjuntoid');
            $zona->zonanombre = $request->get('zonanombre');
            $zona->zonadescripcion = $request->get('zonadescripcion');
            $zona->zonaterminos =  $request->get('zonaterminos');
            $zona->zonareservable =  $request->get('zonareservable');
            $zona->zonahoraapertura =  $request->get('zonahoraapertura');
            $zona->zonahoracierre =  $request->get('zonahoracierre');
            $zona->zonafranjatiempo =  $request->get('zonafranjatiempo');
            $zona->zonaaforomax =  $request->get('zonaaforomax');
            $zona->zonacompartida =  $request->get('zonacompartida');
            $zona->zonacuporeservamax =  $request->get('zonacuporeservamax');
            $zona->zonatiemporeservamax =  $request->get('zonatiemporeservamax');
            $zona->zonareservadiariamax =  $request->get('zonareservadiariamax');
            $zona->zonaprecio =  $request->get('zonaprecio');
            $zona->zonamorosos =  $request->get('zonamorosos');

            $zona->save();

            return redirect()->route('admin.zonas.index')->with('info','La zona comun fue actualizada de forma exitosa');

    }

    public function destroy(Request $request, $id)
    {
        $zona = Zona::find($id);
        $zona->delete();
        $destinationPath = public_path('storage/'.$request->get('conjuntoid').'/'.'zonas');
        $destinationPath = public_path('/storage');
        $fullpath_old = $destinationPath.'/'.$zona->zonaimagen;
        if((File::exists($fullpath_old)) && ($zona->zonaimagen <> 'images/zonacomun.png')) {
            File::delete($fullpath_old);
        }

        return redirect()->route('admin.zonas.index')->with('info','La zona fue eliminada exitosamente');
    }
}
