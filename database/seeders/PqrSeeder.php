<?php

namespace Database\Seeders;

use App\Models\Asunto;
use App\Models\EstadoPqr;
use App\Models\Motivo;
use App\Models\TipoPqr;
use Illuminate\Database\Seeder;

class PqrSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoPqr::create(['tipopqrnombre' => 'Petición','tipopqrtiempo' => 15]);
        TipoPqr::create(['tipopqrnombre' => 'Queja','tipopqrtiempo' => 15]);
        TipoPqr::create(['tipopqrnombre' => 'Reclamo','tipopqrtiempo' => 15]);
        TipoPqr::create(['tipopqrnombre' => 'Sugerencia','tipopqrtiempo' => 15]);
        TipoPqr::create(['tipopqrnombre' => 'Felicitación','tipopqrtiempo' => 15]);

        EstadoPqr::create(['estadonombre' => 'Abierto']);
        EstadoPqr::create(['estadonombre' => 'En tramite']);
        EstadoPqr::create(['estadonombre' => 'Resuelto']);
        EstadoPqr::create(['estadonombre' => 'Cerrado']);

        Asunto::create(['asunto' => 'Administración']);
        Asunto::create(['asunto' => 'Contratistas']);
        Asunto::create(['asunto' => 'Mascotas']);
        Asunto::create(['asunto' => 'Parqueaderos']);
        Asunto::create(['asunto' => 'Personal de Mantenimiento']);
        Asunto::create(['asunto' => 'Personal de Seguridad']);
        Asunto::create(['asunto' => 'Recepción - Porteria']);
        Asunto::create(['asunto' => 'Residentes']);
        Asunto::create(['asunto' => 'Unidad / Apartamento']);
        Asunto::create(['asunto' => 'Vehiculos']);
        Asunto::create(['asunto' => 'Zonas Comunes']);

        Motivo::create(['motivo' => 'Cierre automático / Ticket abandonado']);
        Motivo::create(['motivo' => 'Se creo el ticket por error']);
        Motivo::create(['motivo' => 'Solucionado']);
        Motivo::create(['motivo' => 'Respuesta NO satisfactoria']);
        Motivo::create(['motivo' => 'No se obtuvo respuesta']);
        Motivo::create(['motivo' => 'Ticket no válido']);
    }
}
