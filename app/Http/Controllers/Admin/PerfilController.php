<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Conjunto;
use App\Models\Persona;
use App\Models\Residente;
use App\Models\TipoDocumento;
use App\Models\Unidad;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PerfilController extends Controller
{
    public function edit($id)
    {
        //
    }

    public function show($id)
    {
        $user = User::join('personas','personas.id','users.personaid')
            ->where('users.id', Auth::user()->id)
            ->first();
        $persona = Persona::join('tipo_documentos','tipo_documentos.id','personas.tipodocumentoid')
            ->where('personas.id', Auth::user()->personaid)
            ->first();

        $unidad = Unidad::join('residentes','unidads.id','=','residentes.unidadid')
            ->select('unidads.id')
            ->where('residentes.personaid', Auth::user()->personaid)->first();

        $residentes = Residente::join('personas','personas.id','residentes.personaid')
            ->select('personanombre')
            ->where('unidadid', $unidad->id)
            ->get();

        $tipo_documentos = TipoDocumento::all()->pluck('tipodocumentonombre', 'id');
        $conjuntos = Conjunto::whereIn('id', session('dependencias'))->pluck('conjuntonombre', 'id');
        $unidads = Unidad::join('bloques','bloques.id','=','unidads.bloqueid')
            ->join('residentes','unidads.id','=','residentes.unidadid')
            ->join('personas','personas.id','=','residentes.personaid')
            ->join('conjuntos','conjuntos.id','=','bloques.conjuntoid')
            ->join('barrios','barrios.id','=','conjuntos.barrioid')
            ->leftJoin('unidads_parqueaderos', 'unidad_id', 'unidads.id')
            ->leftJoin('parqueaderos', 'parqueaderos.id', 'parqueadero_id')
            ->leftJoin('vehiculos','unidads.id','=','vehiculos.unidadid')
            ->leftJoin('tipo_vehiculos','tipo_vehiculos.id','=','vehiculos.tipovehiculoid')
            ->select('barrionombre','bloquenombre','unidadnombre','unidads.id', DB::raw("JSON_OBJECTAGG(coalesce(concat(tipovehiculonombre,' ',vehiculomarca),0), coalesce(vehiculoplaca,0) ) AS vehiculos"), DB::raw("JSON_OBJECTAGG(coalesce(parqueaderonumero,0), coalesce(parqueaderopiso,0) ) AS parqueaderos"))
            ->whereIn('bloques.conjuntoid', session('dependencias'))
            ->where('residentes.personaid', Auth::user()->personaid)
            ->GroupByRaw('barrionombre,bloquenombre,unidadnombre,unidads.id')
            ->first();

        return view('admin.perfil.edit', compact('user','persona','residentes','tipo_documentos','conjuntos','unidads'));

    }

    public function update(Request $request, $id)
    {
        if($request->get('module')==1){
            $persona = Persona::find($id);
            $request->validate([
                'personanombre'=>'required|min:3',
                'personacorreo'=>'required|email|unique:personas,personacorreo,'.$persona->id
            ]);

            $persona->update([
                'personanombre'=>$request->get('personanombre'),
                'personacelular'=>$request->get('personacelular'),
                'personacorreo'=>$request->get('personacorreo'),
                'personafechanacimiento'=>str_replace("/", "", $request->get('personafechanacimiento'))
            ]);
        }else{
            $user = User::join('personas','personas.id','users.personaid')
                ->where('users.id', Auth::user()->id)
                ->first();

            $request->validate([
                'current_password' => 'required',
                'password' => 'required|min:8',
                'password_confirmation' => 'required|same:password'
            ]);

            if (Hash::check($request->get('current_password'), $user->password)) {
                $user->update(['password' => Hash::make($request->get('password'))]);
            }else{
                return redirect()->route('admin.perfil.show', 'edit')->with('error','Error: La contraseña actual esta errada');
            }
        }

        return redirect()->route('admin.perfil.show', 'edit')->with('info','Sus datos fueron actualizados de forma exitosa');
    }

}
