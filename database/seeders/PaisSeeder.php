<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pais;

class PaisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pais = new Pais();
        $pais->paisnombre = 'Colombia';
        $pais->paiscodigo = 57;
        $pais->paisabreviatura = 'COL';
        $pais->paisbandera = 'banderas/20210430192453.png';
        $pais->save();

        $pais2 = new Pais();
        $pais2->paisnombre = 'Mexico';
        $pais2->paiscodigo = 34;
        $pais2->paisabreviatura = 'MEX';
        $pais2->paisbandera = 'banderas/20210430193105.png';
        $pais2->save();
    }
}
