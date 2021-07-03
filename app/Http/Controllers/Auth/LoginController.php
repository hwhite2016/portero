<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Persona;
use App\Models\SocialProfile;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    protected $redirectTo = '/home';


    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function redirectToProvider($driver)
    {
        $drivers = ['facebook', 'google'];
        if(in_array($driver, $drivers)){
            return Socialite::driver($driver)->redirect();
        }else{
            return redirect()->route('login')->with('info', $driver.' no es una aplicación valida para iniciar sesión.');
        }

    }

    public function handleProviderCallback(Request $request, $driver)
    {
        if($request->get('error')){
            return redirect()->route('login');
        }

        $userSocialite = Socialite::driver($driver)->user();

        $social_profile = SocialProfile::where('social_id', $userSocialite->getId())
            ->where('social_name', $driver)
            ->first();

        if(!$social_profile){

            $user = User::where('email', $userSocialite->getEmail())->first();

            if(!$user){

                $persona = Persona::create([
                    'tipodocumentoid' => 1,
                    'personadocumento' =>$userSocialite->getId(),
                    'personanombre' =>$userSocialite->getName(),
                    'personacorreo' =>$userSocialite->getEmail(),
                ]);
                $user = User::create([
                    'personaid' => $persona->id,
                    'name' => $userSocialite->getName(),
                    'email' => $userSocialite->getEmail(),
                ]);
                $persona->conjuntos()->sync(1);
                $user->roles()->sync(5);
            }

            $social_profile = SocialProfile::create([
                'user_id' => $user->id,
                'social_id' => $userSocialite->getId(),
                'social_name' => $driver,
                'social_avatar' => $userSocialite->getAvatar(),
            ]);
        }

        Auth::login($social_profile->user);
        return redirect()->route('admin.index');

    }

}
