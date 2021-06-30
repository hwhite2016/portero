<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ciudad;

class CiudadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ciudad = new Ciudad();

        $ciudad->paisid = 1;
        $ciudad->ciudadnombre = 'Barranquilla';
        $ciudad->ciudadcodigo = 5;
        $ciudad->ciudadabreviatura = 'BAQ';

        $ciudad->save();

        $ciudad2 = new Ciudad();

        $ciudad2->paisid = 1;
        $ciudad2->ciudadnombre = 'Cartagena';
        $ciudad2->ciudadcodigo = 4;
        $ciudad2->ciudadabreviatura = 'CTG';

        $ciudad2->save();

        $ciudad3 = new Ciudad();

        $ciudad3->paisid = 2;
        $ciudad3->ciudadnombre = 'Ciudad de Mexico';
        $ciudad3->ciudadcodigo = 25;
        $ciudad3->ciudadabreviatura = 'CDMX';

        $ciudad3->save();

    }
}
