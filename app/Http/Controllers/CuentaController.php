<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CuentaController extends Controller
{
    public function index()
    {
        if(Auth::check()){
            $user = User::find(Auth::user()->id);

            if($user->email_verified_at){

                return redirect()->route('registros.create');
            }else{
                return view('registro.index');
            }
        }else{
            return redirect()->route('admin.index');
        }
    }

    public function verify($id, $seed)
    {

        $user = User::whereEmail($id)->whereProfile_photo_path($seed);
        if ($user->exists()) {
            $user->update([
                'email_verified_at'=> now(),
                'profile_photo_path' => null,
            ]);

            $user = User::whereEmail($id)->first();
            Auth::login($user);
            return redirect()->route('registros.create');

        }else{
            return redirect()->route('admin.index');
        }
    }
}
