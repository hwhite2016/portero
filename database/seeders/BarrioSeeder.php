<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Barrio;

class BarrioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $barrio = new Barrio();

        $barrio->ciudadid = 1;
        $barrio->barrionombre = 'Miramar';
        $barrio->barrioestrato = 4;

        $barrio->save();

        $barrio2 = new Barrio();

        $barrio2->ciudadid = 1;
        $barrio2->barrionombre = 'Alameda del Rio';
        $barrio2->barrioestrato = 3;

        $barrio2->save();
    }
}
