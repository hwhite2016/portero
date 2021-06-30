<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Parqueadero;

class ParqueaderoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Parqueadero::create(['conjuntoid' => 1, 'parqueaderonumero' => '101', 'parqueaderopiso'=>1,
                            'parqueaderotipo' => 'Visitante', 'parqueaderoestado'=>'0']);
        Parqueadero::create(['conjuntoid' => 1, 'parqueaderonumero' => '102', 'parqueaderopiso'=>1,
                            'parqueaderotipo' => 'Visitante', 'parqueaderoestado'=>'0']);
        Parqueadero::create(['conjuntoid' => 1, 'parqueaderonumero' => '301', 'parqueaderopiso'=>3,
                            'parqueaderotipo' => 'Asignado', 'parqueaderoestado'=>'1']);
        Parqueadero::create(['conjuntoid' => 1, 'parqueaderonumero' => '302', 'parqueaderopiso'=>3,
                            'parqueaderotipo' => 'Asignado', 'parqueaderoestado'=>'1']);
        Parqueadero::create(['conjuntoid' => 1, 'parqueaderonumero' => '439', 'parqueaderopiso'=>5,
                            'parqueaderotipo' => 'Asignado', 'parqueaderoestado'=>'1']);
        Parqueadero::create(['conjuntoid' => 2, 'parqueaderonumero' => '103', 'parqueaderopiso'=>1,
                            'parqueaderotipo' => 'Visitante', 'parqueaderoestado'=>'0']);
        Parqueadero::create(['conjuntoid' => 2, 'parqueaderonumero' => '402', 'parqueaderopiso'=>4,
                            'parqueaderotipo' => 'Asignado', 'parqueaderoestado'=>'1']);
    }
}
