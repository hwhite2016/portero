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
        TipoPqr::create(['tipopqrnombre' => 'Petición']);
        TipoPqr::create(['tipopqrnombre' => 'Queja']);
        TipoPqr::create(['tipopqrnombre' => 'Reclamo']);
        TipoPqr::create(['tipopqrnombre' => 'Sugerencia']);
        TipoPqr::create(['tipopqrnombre' => 'Felicitación']);

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

        Motivo::create(['motivo' => 'Se creo el ticket por error']);
        Motivo::create(['motivo' => 'Solucionado']);
        Motivo::create(['motivo' => 'Ticket no valido']);
    }
}
