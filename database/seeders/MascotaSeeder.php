<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TipoMascota;

class MascotaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoMascota::create(['tipomascotanombre' => 'Perro']);
        TipoMascota::create(['tipomascotanombre' => 'Gato']);
        TipoMascota::create(['tipomascotanombre' => 'Loro']);
        TipoMascota::create(['tipomascotanombre' => 'Pajaro']);
        TipoMascota::create(['tipomascotanombre' => 'Conejo']);
        TipoMascota::create(['tipomascotanombre' => 'Pez']);
        TipoMascota::create(['tipomascotanombre' => 'Tortuga']);
        TipoMascota::create(['tipomascotanombre' => 'Hamster']);
        TipoMascota::create(['tipomascotanombre' => 'Lagarto']);
        TipoMascota::create(['tipomascotanombre' => 'Otro']);
    }
}
