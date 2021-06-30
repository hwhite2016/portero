<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TipoVehiculo;

class VehiculoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoVehiculo::create(['tipovehiculonombre' => 'Automovil']);
        TipoVehiculo::create(['tipovehiculonombre' => 'Camioneta']);
        TipoVehiculo::create(['tipovehiculonombre' => 'Motocicleta']);
        TipoVehiculo::create(['tipovehiculonombre' => 'Otro']);

    }
}
