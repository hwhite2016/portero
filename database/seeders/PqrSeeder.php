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
        TipoPqr::create(['tipopqrnombre' => 'Solicitud']);
        TipoPqr::create(['tipopqrnombre' => 'Queja']);
        TipoPqr::create(['tipopqrnombre' => 'Reclamo']);
        TipoPqr::create(['tipopqrnombre' => 'Felicitación']);

        EstadoPqr::create(['estadonombre' => 'Abierta']);
        EstadoPqr::create(['estadonombre' => 'En tramite']);
        EstadoPqr::create(['estadonombre' => 'Resuelta']);
        EstadoPqr::create(['estadonombre' => 'Cerrada']);

        Asunto::create(['asunto' => 'Cuota de Administración']);
        Asunto::create(['asunto' => 'Zonas Comunes']);
        Asunto::create(['asunto' => 'Recepción - Porteria']);
        Asunto::create(['asunto' => 'Personal de Mantenimiento']);
        Asunto::create(['asunto' => 'Personal de Seguridad']);
        Asunto::create(['asunto' => 'Contratistas']);
        Asunto::create(['asunto' => 'Mascotas']);
        Asunto::create(['asunto' => 'Vehiculos']);
        Asunto::create(['asunto' => 'Residentes']);

        Motivo::create(['motivo' => 'Cree el ticket por error']);
        Motivo::create(['motivo' => 'ya se solucionó']);
        Motivo::create(['motivo' => 'Solicitud no valida']);
    }
}
