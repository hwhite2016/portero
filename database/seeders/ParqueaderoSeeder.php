<?php

namespace Database\Seeders;

use App\Models\EstadoParqueadero;
use Illuminate\Database\Seeder;
use App\Models\Parqueadero;
use App\Models\TipoParqueadero;

class ParqueaderoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EstadoParqueadero::create(['estadoparqueaderonombre' => 'Disponible']);
        EstadoParqueadero::create(['estadoparqueaderonombre' => 'Ocupado']);

        TipoParqueadero::create(['tipoparqueaderonombre' => 'Asignado']);
        TipoParqueadero::create(['tipoparqueaderonombre' => 'Discapacitado']);
        TipoParqueadero::create(['tipoparqueaderonombre' => 'Visitante']);
        TipoParqueadero::create(['tipoparqueaderonombre' => 'Motos']);


        // Parqueadero::create(['conjuntoid' => 1, 'parqueaderonumero' => '101', 'parqueaderopiso'=>1,
        //                     'tipoparqueaderoid' => 1, 'parqueaderoestado'=>'0']);
        // Parqueadero::create(['conjuntoid' => 1, 'parqueaderonumero' => '102', 'parqueaderopiso'=>1,
        //                     'tipoparqueaderoid' => 1, 'parqueaderoestado'=>'0']);
        // Parqueadero::create(['conjuntoid' => 1, 'parqueaderonumero' => '301', 'parqueaderopiso'=>3,
        //                     'tipoparqueaderoid' => 1, 'parqueaderoestado'=>'1']);

    }
}
