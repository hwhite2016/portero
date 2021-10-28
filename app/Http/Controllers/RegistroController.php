<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ValidarRegistroRequest;
use App\Mail\WelcomeMailable;
use App\Models\Barrio;
use App\Models\Bloque;
use App\Models\Ciudad;
use Illuminate\Http\Request;
use illuminate\Database\Eloquent\Collection;
use App\Models\Unidad;
use App\Models\TipoDocumento;
use App\Models\Conjunto;
use App\Models\Mascota;
use App\Models\Pais;
use App\Models\Parqueadero;
use App\Models\Persona;
use App\Models\Registro;
use App\Models\TipoResidente;
use App\Models\Relation;
use App\Models\Residente;
use App\Models\TipoMascota;
use App\Models\TipoPropietario;
use App\Models\TipoVehiculo;
use App\Models\User;
use App\Models\Vehiculo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class RegistroController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        //$this->middleware('can:registros.index')->only('index');
        //$this->middleware('can:registros.edit')->only('edit', 'update');
        //$this->middleware('can:registros.destroy')->only('destroy');

    }

    public function create(Request $request)
    {
        if(Auth::check()){
            $user = User::find(Auth::user()->id);
            if($user->email_verified_at){

                $pais = Pais::whereId(1)->pluck('paisnombre', 'id');
                $ciudads = Ciudad::whereId(1)->pluck('ciudadnombre', 'id');
                $barrios = Barrio::whereId(1)->pluck('barrionombre', 'id');
                $bloques = [];
                if($request->get('item')){
                    if (Conjunto::whereConjuntokey($request->get('item'))->exists()) {
                        $conjuntos = Conjunto::whereConjuntokey($request->get('item'))->pluck('conjuntonombre', 'id');
                        $condominio = Conjunto::whereConjuntokey($request->get('item'))->first();
                        $bloques = Bloque::whereConjuntoid($condominio->id)->pluck('bloquenombre', 'id');
                        $bloques->prepend('Seleccione el bloque', '');
                    }else{
                        $conjuntos = Conjunto::whereConjuntoestado(1)->pluck('conjuntonombre', 'id');
                        $conjuntos->prepend('Seleccione la copropiedad', '');
                    }
                }else{
                    $conjuntos = Conjunto::whereConjuntoestado(1)->pluck('conjuntonombre', 'id');
                    $conjuntos->prepend('Seleccione la copropiedad', '');
                }
                $tipo_documentos = TipoDocumento::all()->pluck('tipodocumentonombre', 'id');
                $tipo_propietarios = TipoPropietario::all()->pluck('tipopropietarionombre', 'id');

                return view('registro.create', compact('pais','ciudads','barrios','conjuntos', 'bloques','tipo_documentos','tipo_propietarios'));

            }else{
                return view('registro.index');
            }
        }else{
            return redirect()->route('admin.index');
        }
    }

    public function estado($id){
        $registro = Registro::find($id);
        $unidad = Unidad::find($registro->unidadid);
        $registro->update([
            'estado_id' => 3,
        ]);
        $unidad->update([
            'estado_id' => 3,
        ]);

        return view('registro.verificacion')->with('info','El registro ha finalizado exitosamente y esta en proceso de validación.');
    }

    public function getBlock($id){

        $bloque = Bloque::join('conjuntos','conjuntos.id','=','bloques.conjuntoid')
        ->whereConjuntoid($id)
        ->select('bloques.id', 'bloquenombre')
        ->get();
        if(isset($bloque)){
           return response()->json(['bloque' => $bloque], 200);
        }else{
            return "No se encontraron resultados" . $id ;
        }
    }

    public function getHome($id){

        $unidad = Unidad::join('bloques','bloques.id','=','unidads.bloqueid')
        ->whereBloqueid($id)
        ->whereNotIn('unidads.id', function ($query) {
            $query->select('unidadid')
                  ->from('registros');
        })
        ->select('unidads.id', 'unidadnombre')
        ->get();
        if(isset($unidad)){
           return response()->json(['unidad' => $unidad], 200);
        }else{
            return "No se encontraron resultados" . $id ;
        }
    }

    public function store(ValidarRegistroRequest $request)
    {
        $request->validate([
            'conjuntoid'=>'required',
            'bloqueid'=>'required',
            'unidadid'=>'required',
            'tipodocumentoid'=>'required',
            'personadocumento'=>'required|min:3|alpha_num',
            'personanombre'=>'required|min:3',
            'personacorreo'=>'required|email',

        ]);

        if (Persona::where('personadocumento', '=', $request->get('personadocumento'))->exists()) {
            $persona = Persona::where('personadocumento','=',$request->get('personadocumento'))->first();
        }else{
            $request->validate([
                'personacorreo'=>'unique:personas',
            ]);
            $persona = Persona::create([
                'tipodocumentoid'=>$request->get('tipodocumentoid'),
                'personadocumento'=>$request->get('personadocumento'),
                'personanombre'=>$request->get('personanombre'),
                'personacelular'=>$request->get('personacelular'),
                'personacorreo'=>$request->get('personacorreo'),
                'personafechanacimiento'=>str_replace("/", "", $request->get('personafechanacimiento')),
            ]);
        }

        $persona->conjuntos()->detach($request->conjuntoid);
        $persona->conjuntos()->attach($request->conjuntoid);


        $registro = Registro::create([
            'unidadid'=>$request->get('unidadid'),
            'personaid'=>$persona->id,
            'estado_id'=> 2,
         ]);

        $user = User::find(Auth::user()->id);
        $user->update([
            'personaid'=>$persona->id,
        ]);

        $user->assignRole(1);

        $unidad = Unidad::find($request->get('unidadid'));
        if($request->get('tipopropietarioid') < 4){
            $unidad->update([
                'tipopropietarioid'=>$request->get('tipopropietarioid'),
                'propietarioid' => $persona->id,
                'estado_id' => 2,
            ]);
            $tiporesidente = 1;
        }else{
            $unidad->update([
                'estado_id' => 2,
            ]);
            $tiporesidente = 2;
        }

        if($request->get('reside') == 1){
            if (!Residente::where('personaid', '=', $persona->id)->whereUnidadid($request->get('unidadid'))->exists()) {
                Residente::create([
                    'personaid'=>$persona->id,
                    'unidadid'=>$request->get('unidadid'),
                    'tiporesidenteid'=>$tiporesidente,
                    'relationid'=>1,
                ]);
            }
        }

        return redirect()->route('registros.edit', $registro->id)->with('info','El registro fue agregado de forma exitosa');
    }

    public function show($id)
    {
        //
    }

    public function edit(Registro $registro)
    {
        $this->authorize('pendiente', $registro);

        $personaid = Auth::user()->personaid;
        if(!$personaid) return redirect()->route('admin.index');
        $registro = Registro::join('unidads','registros.unidadid','unidads.id')
            ->join('bloques','bloques.id','=','unidads.bloqueid')
            ->join('conjuntos','conjuntos.id','bloques.conjuntoid')
            ->select('registros.id','registros.unidadid','conjuntoid','bloqueid','registros.estado_id', 'registros.id as registroid')
            ->where('registros.id', $registro->id)
            ->first();

        if($registro->estado_id != 3){
            if($registro->estado_id == 4) return redirect()->route('admin.index');
            $conjuntos = Conjunto::whereId($registro->conjuntoid)->pluck('conjuntonombre', 'id');
            $bloques = Bloque::whereId($registro->bloqueid)->pluck('bloquenombre', 'id');
            $unidads = Unidad::whereId($registro->unidadid)->pluck('unidadnombre', 'id');
            $tipo_documentos = TipoDocumento::all()->pluck('tipodocumentonombre', 'id');
            $tipo_propietarios = TipoPropietario::where('id','<',4)->pluck('tipopropietarionombre', 'id');

            $parqueaderos = Parqueadero::where('conjuntoid', $registro->conjuntoid)->pluck('parqueaderonumero', 'id');

            $propietario = Persona::join('unidads', 'propietarioid', 'personas.id')
                ->where('unidads.id', $registro->unidadid)->pluck('personanombre', 'personas.id');

            $residentes = Residente::join('tipo_residentes', 'tipo_residentes.id', '=', 'tiporesidenteid')
            ->join('personas', 'personas.id', '=', 'personaid')
            ->join('unidads', 'unidads.id', '=', 'unidadid')
            ->join('relations', 'relations.id', '=', 'relationid')
            ->select(Residente::raw('residentes.id, personanombre, tiporesidentenombre, personacelular, relationname' ))
            ->where('unidads.id', $registro->unidadid)
            ->get();
            $vehiculos = Vehiculo::join('tipo_vehiculos', 'tipo_vehiculos.id', '=', 'tipovehiculoid')
            ->join('unidads', 'unidads.id', '=', 'unidadid')
            ->select(Vehiculo::raw('vehiculos.id, tipovehiculonombre, vehiculomarca, vehiculoplaca' ))
            ->where('unidads.id', $registro->unidadid)
            ->get();
            $mascotas = Mascota::join('tipo_mascotas', 'tipo_mascotas.id', '=', 'tipomascotaid')
            ->join('unidads', 'unidads.id', '=', 'unidadid')
            ->select(mascota::raw('mascotas.id, tipomascotanombre, mascotaraza, mascotanombre, mascotaedad' ))
            ->where('unidads.id', $registro->unidadid)
            ->get();

            return view('registro.edit', compact('registro','conjuntos','bloques','unidads','tipo_documentos','tipo_propietarios','residentes','vehiculos','mascotas','parqueaderos','propietario'));
        }else{
            return view('registro.verificacion');
        }
    }

    public function update(Request $request, Registro $registro)
    {
        $this->authorize('pendiente', $registro);

        $unidad = Unidad::find($registro->unidadid);
        $unidad->update(['propietarioid' => null]);

        $request->validate([
            'conjuntoid'=>'required',
            'bloqueid'=>'required',
            'unidadid'=>'required',
        ]);

        if($request->get('propietarioid')){
             $unidad->update([
                'tipopropietarioid'=>$request->get('tipopropietarioid'),
                'propietarioid' => $request->get('propietarioid'),
            ]);
        }

        $registro->parqueaderos()->sync($request->parqueaderos);

        return redirect()->route('registros.edit', $registro->id)->with('info','El registro fue actualizado de forma exitosa');

    }

    public function destroy(Request $request, $id)
    {
        //
    }

    public function createResidente(Request $request, $id)
    {

        $tipo_documentos = TipoDocumento::all()->pluck('tipodocumentonombre', 'id');
        $tipo_residentes = TipoResidente::all()->pluck('tiporesidentenombre', 'id');
        $relations = Relation:: all()->pluck('relationname', 'id');

        $conjuntos = Unidad::join('bloques','bloques.id','=','unidads.bloqueid')
            ->join('conjuntos','conjuntos.id','=','bloques.conjuntoid')
            ->select('conjuntonombre','conjuntos.id')
            ->where('unidads.id', '=', $id)
            ->pluck('conjuntonombre', 'id');


        $unidads = Unidad::join('bloques','bloques.id','=','unidads.bloqueid')
            ->select(
            Unidad::raw("CONCAT(bloquenombre,' - ',unidadnombre) AS unidad"),'unidads.id')
            ->where('unidads.id', '=', $id)
            ->pluck('unidad', 'unidads.id');

        //$unidads->prepend('Seleccione la unidad', '');

        return view('registro.createResidente', compact('tipo_documentos', 'tipo_residentes', 'relations', 'conjuntos', 'unidads'));

    }

    public function storeResidente(Request $request)
    {
        $msj = 'El residente fue agregado de forma exitosa';
        $request->validate([
            'conjuntoid'=>'required',
            'unidadid'=>'required',
            'tipodocumentoid'=>'required',
            'personadocumento'=>'required|min:3|alpha_num',
            'personanombre'=>'required|min:3',
            'unidadid' => 'unique:residentes,unidadid,NULL,id,personaid,' . $request->get('personaid')
        ]);
        if (Persona::where('personadocumento', '=', $request->get('personadocumento'))->exists()) {
            $persona = Persona::where('personadocumento','=',$request->get('personadocumento'))->first();
        }else{
            $request->validate([
                'personacorreo'=>'unique:personas',
            ]);
            $persona = Persona::create([
                'tipodocumentoid'=>$request->get('tipodocumentoid'),
                'personadocumento'=>$request->get('personadocumento'),
                'personanombre'=>$request->get('personanombre'),
                'personacelular'=>$request->get('personacelular'),
                'personacorreo'=>$request->get('personacorreo'),
                'personafechanacimiento'=>str_replace("/", "", $request->get('personafechanacimiento')),
             ]);
        }

        if($request->get('tiporesidenteid')){
            if (!Residente::where('personaid', '=', $persona->id)->whereUnidadid($request->get('unidadid'))->exists()) {
                Residente::create([
                    'personaid'=>$persona->id,
                    'unidadid'=>$request->get('unidadid'),
                    'tiporesidenteid'=>$request->get('tiporesidenteid'),
                    'relationid'=>$request->get('relationid'),
                ]);
            }else{
                $msj = 'Error: Ya esta registrada en la unidad un residente con ese número de documento.';
            }
        }
        $registro= Registro::where('unidadid','=',$request->get('unidadid'))->first();

        return redirect()->route('registros.edit', $registro->id)->with('info', $msj);

    }

    public function destroyResidente($id)
    {
        $residente = Residente::find($id);
        $residente->delete();

        $registro= Registro::where('unidadid','=',$residente->unidadid)->first();

        return redirect()->route('registros.edit', $registro->id)->with('info', 'El residente fue eliminado exitosamente');
    }

    public function createVehiculo(Request $request, $id)
    {

        $tipo_vehiculos = TipoVehiculo::all()->pluck('tipovehiculonombre', 'id');

        $conjuntos = Unidad::join('bloques','bloques.id','=','unidads.bloqueid')
            ->join('conjuntos','conjuntos.id','=','bloques.conjuntoid')
            ->select('conjuntonombre','conjuntos.id')
            ->where('unidads.id', '=', $id)
            ->pluck('conjuntonombre', 'id');

        $unidads = Unidad::join('bloques','bloques.id','=','unidads.bloqueid')
            ->select(
            Unidad::raw("CONCAT(bloquenombre,' - ',unidadnombre) AS unidad"),'unidads.id')
            ->where('unidads.id', '=', $id)
            ->pluck('unidad', 'unidads.id');

        //$unidads->prepend('Seleccione la unidad', '');

        return view('registro.createVehiculo', compact('tipo_vehiculos', 'conjuntos', 'unidads'));

    }

    public function storeVehiculo(Request $request)
    {
        $request->validate([
            'conjuntoid'=>'required',
            'unidadid'=>'required',
            'vehiculoplaca' => 'unique:vehiculos'
        ]);

        Vehiculo::create([
            'unidadid'=>$request->get('unidadid'),
            'tipovehiculoid'=>$request->get('tipovehiculoid'),
            'vehiculoplaca'=>$request->get('vehiculoplaca'),
            'vehiculomarca'=>$request->get('vehiculomarca')
        ]);

        $registro= Registro::where('unidadid','=',$request->get('unidadid'))->first();
        return redirect()->route('registros.edit', $registro->id)->with('info', 'El vehiculo fue agregado de forma exitosa');

    }

    public function destroyVehiculo($id)
    {
        $vehiculo = Vehiculo::find($id);
        $vehiculo->delete();

        $registro= Registro::where('unidadid','=',$vehiculo->unidadid)->first();
        return redirect()->route('registros.edit', $registro->id)->with('info', 'El vehiculo fue eliminado exitosamente');
    }

    public function createMascota(Request $request, $id)
    {

        $tipo_mascotas = TipoMascota::all()->pluck('tipomascotanombre', 'id');
        $conjuntos = Unidad::join('bloques','bloques.id','=','unidads.bloqueid')
            ->join('conjuntos','conjuntos.id','=','bloques.conjuntoid')
            ->select('conjuntonombre','conjuntos.id')
            ->where('unidads.id', '=', $id)
            ->pluck('conjuntonombre', 'id');

        $unidads = Unidad::join('bloques','bloques.id','=','unidads.bloqueid')
            ->select(
            Unidad::raw("CONCAT(bloquenombre,' - ',unidadnombre) AS unidad"),'unidads.id')
            ->where('unidads.id', '=', $id)
            ->orderBy('unidad','ASC')
            ->pluck('unidad', 'unidads.id');

        //$unidads->prepend('Seleccione la unidad', '');

        return view('registro.createMascota', compact('tipo_mascotas', 'conjuntos', 'unidads'));

    }

    public function storeMascota(Request $request)
    {
        $request->validate([
            'conjuntoid'=>'required',
            'unidadid'=>'required',
            'tipomascotaid' => 'required'
        ]);

        mascota::create([
            'unidadid'=>$request->get('unidadid'),
            'tipomascotaid'=>$request->get('tipomascotaid'),
            'mascotaraza'=>$request->get('mascotaraza'),
            'mascotanombre'=>$request->get('mascotanombre'),
            'mascotaedad'=>$request->get('mascotaedad')
        ]);

        $registro= Registro::where('unidadid','=',$request->get('unidadid'))->first();
        return redirect()->route('registros.edit', $registro->id)->with('info', 'La mascota fue agregada de forma exitosa');

    }

    public function destroyMascota($id)
    {
        $mascota = Mascota::find($id);
        $mascota->delete();

        $registro= Registro::where('unidadid','=',$mascota->unidadid)->first();
        return redirect()->route('registros.edit', $registro->id)->with('info', 'El mascota fue eliminado exitosamente');
    }

}
