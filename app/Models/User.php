<?php

namespace App\Models;

use App\Notifications\CustomResetPasswordNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use NotificationChannels\WebPush\HasPushSubscriptions;
use App\Models\SocialProfile;

//use Laravel\Fortify\TwoFactorAuthenticatable;
//use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    use HasFactory, Notifiable, HasPushSubscriptions, HasRoles;

    //Relacion uno a muchos
    public function socialProfiles(){
    	return $this->hasMany(SocialProfile::class);
    }

    //Relacion muchos a muchos
    public function conjuntos(){
    	return $this->belongsToMany(Conjunto::class, 'users_conjuntos');
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomResetPasswordNotification($token));
    }

    public function adminlte_image()
    {
        $social_profile = $this->socialProfiles->first();
        if($social_profile){
            return $social_profile->social_avatar;
        }else{
            if (Auth::user()){
                $auth_nombre = Auth::user()->name;
                $arr_nombre = explode(' ', $auth_nombre);
                $nombre = $arr_nombre[0];
                $apellido = '';
                if (count($arr_nombre) > 1)  $apellido = $arr_nombre[1];
                if ($apellido <> '') $nombre = $nombre .'+'.$apellido;

                return 'https://ui-avatars.com/api?name='.$nombre.'&color=5F91E2&background=EBF4FF&bold=true&rounded=true';
            }else{
                return 'https://picsum.photos/300/300';
            }
        }
    }

    public function adminlte_desc()
    {
        return 'Super Administrador';
    }

    public function adminlte_profile_url()
    {
        return 'user/profile';
    }

    protected $fillable = [
        'personaid',
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
