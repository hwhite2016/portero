<?php

use App\Http\Controllers\Admin\AnuncioController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PaisController;
use App\Http\Controllers\Admin\CiudadController;
use App\Http\Controllers\Admin\BarrioController;
use App\Http\Controllers\Admin\ConjuntoController;
use App\Http\Controllers\Admin\CondominioController;
use App\Http\Controllers\Admin\BloqueController;
use App\Http\Controllers\Admin\ParqueaderoController;
use App\Http\Controllers\Admin\ClaseUnidadController;
use App\Http\Controllers\Admin\EmpleadoController;
use App\Http\Controllers\Admin\UnidadController;
use App\Http\Controllers\Admin\PersonaController;
use App\Http\Controllers\Admin\ResidenteController;
use App\Http\Controllers\Admin\VehiculoController;
use App\Http\Controllers\Admin\MascotaController;
use App\Http\Controllers\Admin\VisitanteController;
use App\Http\Controllers\Admin\EntregaController;
use App\Http\Controllers\Admin\EventCalendarController;
use App\Http\Controllers\Admin\InvitadoController;
use App\Http\Controllers\Admin\NormaController;
use App\Http\Controllers\Admin\NotificationsController;
use App\Http\Controllers\Admin\OrganoController;
use App\Http\Controllers\Admin\PqrController;
use App\Http\Controllers\Admin\ReservaController;
use App\Http\Controllers\Admin\SeguimientoController;
use App\Http\Controllers\Admin\ZonaController;
use App\Http\Controllers\Admin\ZonaHorarioController;
use Illuminate\Support\Facades\Auth;

Route::middleware(['auth:sanctum', 'verified', 'rol'])->group(function () {

    Route::get('/', [HomeController::class, 'index'])->name('admin.index');
    Route::get('/notifications/get', [NotificationsController::class, 'getNotificationsData']);
	Route::resource('/users', UserController::class)->names('admin.users');
	Route::resource('/roles', RoleController::class)->names('admin.roles');
	Route::resource('/pais', PaisController::class)->names('admin.pais');
	Route::resource('/ciudads', CiudadController::class)->names('admin.ciudads');
	Route::resource('/barrios', BarrioController::class)->names('admin.barrios');
	Route::resource('/conjuntos', ConjuntoController::class)->names('admin.conjuntos');
    Route::resource('/condominios', CondominioController::class)->names('admin.condominios');
	Route::resource('/bloques', BloqueController::class)->names('admin.bloques');
    Route::resource('/parqueaderos', ParqueaderoController::class)->names('admin.parqueaderos');
    Route::resource('/zonas', ZonaController::class)->names('admin.zonas');
    //Route::resource('/zonaHorario', ZonaHorarioController::class)->names('admin.zonaHorario');
    Route::get('/terminosModal/{id}', [ZonaController::class, 'terminosModal'])->name('admin.zonas.terminosModal');
    Route::get('/calendario/{id}', [ZonaController::class, 'calendario'])->name('admin.zonas.calendario');
    Route::resource('/event', EventCalendarController::class)->names('admin.eventCalendar');
    Route::get('/eventos', [ZonaController::class, 'eventos'])->name('admin.zonas.eventos');
    Route::resource('/reservas', ReservaController::class)->names('admin.reservas');
    Route::get('/cupo/{id}', [ReservaController::class, 'getCupoMaximo'])->name('admin.reservas.cupo');
    Route::post('/horas', [ReservaController::class, 'getHoras'])->name('admin.reservas.horas');
    Route::resource('/clase_unidads', ClaseUnidadController::class)->names('admin.clase_unidads');
    Route::get('/clase_unidadModal', [ClaseUnidadController::class, 'getModal'])->name('admin.clase_unidads.getModal');
    Route::resource('/unidads', UnidadController::class)->names('admin.unidads');
    Route::get('/unidads/export/{id?}', [UnidadController::class, 'export'])->name('admin.unidads.export');
    Route::get('/propietarioModal/{id}', [UnidadController::class, 'getModal'])->name('admin.unidads.getModal');
    Route::resource('/personas', PersonaController::class)->names('admin.personas');
    Route::resource('/empleados', EmpleadoController::class)->names('admin.empleados');
    Route::resource('/residentes', ResidenteController::class)->names('admin.residentes');
    Route::get('/residenteModal/{id}', [ResidenteController::class, 'createModal'])->name('admin.residentes.createModal');
    Route::get('/list', [ResidenteController::class, 'list'])->name('admin.residentes.list');
    Route::resource('/vehiculos', VehiculoController::class)->names('admin.vehiculos');
    Route::get('/vehiculoModal/{id}', [VehiculoController::class, 'createModal'])->name('admin.vehiculos.createModal');
    Route::resource('/mascotas', MascotaController::class)->names('admin.mascotas');
    Route::get('/mascotaModal/{id}', [MascotaController::class, 'createModal'])->name('admin.mascotas.createModal');
    Route::resource('/visitantes', VisitanteController::class)->names('admin.visitantes');
    Route::get('/hvisitantes', [VisitanteController::class, 'getVisitantes'])->name('admin.visitantes.getVisitantes');
    Route::get('/hdestroy/{id}', [VisitanteController::class, 'hdestroy'])->name('admin.visitantes.hdestroy');
    Route::get('/restaurar/{id}', [VisitanteController::class, 'restaurar'])->name('admin.visitantes.restaurar');
    Route::get('/documento/{id}', [VisitanteController::class, 'getInfoDocumento'])->name('admin.visitantes.documento');
    Route::resource('/invitados', InvitadoController::class)->names('admin.invitados');
    Route::get('/import/{id}',[InvitadoController::class, 'importForm'])->name('admin.invitados.importForm');
    Route::post('/import',[InvitadoController::class, 'import'])->name('admin.invitados.import');
    Route::get('/export/{id}', [InvitadoController::class, 'export'])->name('admin.invitados.export');
    Route::get('/persona/{id}', [EntregaController::class, 'getInfoPersona'])->name('admin.entregas.persona');
    Route::resource('/entregas', EntregaController::class)->names('admin.entregas');
    Route::resource('/seguimiento', SeguimientoController::class)->names('admin.seguimiento');
    //Route::get('/seguimiento', [EntregaController::class, 'getEntregas'])->name('admin.entregas.getEntregas');
    Route::get('/notificacion/{id?}', [NotificationsController::class, 'show'])->name('admin.notificaciones.show');
    Route::get('/countNotification', [NotificationsController::class, 'countNotification'])->name('admin.notificaciones.countNotification');
    Route::post('/markNotificacion', [NotificationsController::class, 'markNotificacion'])->name('markNotificacion');
    Route::resource('/pqrs', PqrController::class)->names('admin.pqrs');
    Route::get('/motivo', [PqrController::class, 'getMotivo'])->name('admin.pqrs.motivo');
    Route::post('/estado/{id?}', [PqrController::class, 'changeEstado'])->name('admin.pqrs.estado');
    Route::resource('/anuncios', AnuncioController::class)->names('admin.anuncios');
    Route::get('/anuncios/email/{id}', [AnuncioController::class, 'email'])->name('admin.anuncios.email');
    Route::get('/anuncios/telegram/{id}', [AnuncioController::class, 'telegram'])->name('admin.anuncios.telegram');
    Route::get('/anuncios/del/{id}', [AnuncioController::class, 'delFile'])->name('admin.anuncios.delFile');

    Route::resource('/organos', OrganoController::class)->names('admin.organos');
    Route::get('/estructura', [OrganoController::class, 'estructura'])->name('admin.organos.estructura');
    Route::resource('/documentos', NormaController::class)->names('admin.normas');

    Route::get('/markAsRead', function(){
        Auth::user()->unreadNotifications->markAsRead();
        return redirect()->back();
    })->name('markAsRead');

    Route::get('/markAsNotRead', function(){
        Auth::user()->unreadNotifications->update(['read_at' => NULL]);
        return redirect()->back();
    })->name('markAsNotRead');

    Route::get('/orders', function(){
        return view('admin.orders.payment');
    });
    Route::get('/orders2', function(){
        return view('admin.orders.invoice-print');
    });


});


Route::get('notifications/get', [NotificationsController::class, 'getNotificationsData']);


