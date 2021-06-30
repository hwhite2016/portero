<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UnidadsParqueadero;

class UnidadParqueaderoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        unidadsParqueadero::create(['unidad_id' => '7', 'parqueadero_id'=>'5']);
        unidadsParqueadero::create(['unidad_id' => '10', 'parqueadero_id'=>'6']);
    }
}
