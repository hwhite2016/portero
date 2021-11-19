<?php

use App\Http\Controllers\RegistroController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PushSubscriptionController;
use App\Http\Controllers\ContactanosController;
use App\Http\Controllers\CuentaController;
use App\Http\Controllers\TelegramBotController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::resource('/registro', RegistroController::class)->names('registros');
Route::get('/registro/estado/{id}', [RegistroController::class, 'estado'])->name('registros.estado');
Route::get('/getBlock/{id}', [RegistroController::class, 'getBlock'])->name('registros.bloque');
Route::get('/getHome/{id}', [RegistroController::class, 'getHome'])->name('registros.unidad');
Route::get('/registro/verify/{id}/{seed}', [CuentaController::class, 'verify'])->name('cuentas.verify');
Route::get('/registro/residenteModal/{id}', [RegistroController::class, 'createResidente'])->name('registros.createResidente');
Route::post('/registro/residenteStore', [RegistroController::class, 'storeResidente'])->name('registros.storeResidente');
Route::delete('/registro/residenteDestroy/{id}', [RegistroController::class, 'destroyResidente'])->name('registros.destroyResidente');
Route::get('/registro/vehiculoModal/{id}', [RegistroController::class, 'createVehiculo'])->name('registros.createVehiculo');
Route::post('/registro/vehiculoStore', [RegistroController::class, 'storeVehiculo'])->name('registros.storeVehiculo');
Route::delete('/registro/vehiculoDestroy/{id}', [RegistroController::class, 'destroyVehiculo'])->name('registros.destroyVehiculo');
Route::get('/registro/mascotaModal/{id}', [RegistroController::class, 'createMascota'])->name('registros.createMascota');
Route::post('/registro/mascotaStore', [RegistroController::class, 'storeMascota'])->name('registros.storeMascota');
Route::delete('/registro/mascotaDestroy/{id}', [RegistroController::class, 'destroyMascota'])->name('registros.destroyMascota');

Route::get('/updated-activity', [TelegramBotController::class, 'updatedActivity']);

Route::get('/terminos', function () {
    return view('terminos');
});

Route::get('/privacidad', function () {
    return view('privacidad');
});

Auth::routes();

Route::get('/rol', [HomeController::class, 'index'])->name('home.index');
Route::post('/verify', [HomeController::class, 'show'])->name('home.show');

// Notifications
Route::post('notifications', [NotificationController::class, 'store']);
Route::get('notifications', [NotificationController::class, 'index']);
Route::patch('notifications/{id}/read', [NotificationController::class, 'markAsRead']);
Route::post('notifications/mark-all-read', [NotificationController::class, 'markAllRead']);
Route::post('notifications/{id}/dismiss', [NotificationController::class, 'dismiss']);

// Push Subscriptions
Route::post('subscriptions', [PushSubscriptionController::class, 'update']);
Route::post('subscriptions/delete', [PushSubscriptionController::class, 'destroy']);

Route::get('login/{driver}', [LoginController::class, 'redirectToProvider']);
Route::get('login/{driver}/callback', [LoginController::class, 'handleProviderCallback']);

Route::get('/contactanos', [ContactanosController::class, 'index'])->name('contactanos.index');
Route::post('/contactanos', [ContactanosController::class, 'store'])->name('contactanos.store');

// Manifest file (optional if VAPID is used)
Route::get('manifest.json', function () {
    return [
        'name' => config('app.name'),
        'gcm_sender_id' => config('webpush.gcm.sender_id'),
    ];
});

