<?php

namespace Database\Seeders;

use App\Models\Organo;
use App\Models\TipoNorma;
use Illuminate\Database\Seeder;

class OrganoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Organo::create(['conjuntoid' => 1,
                        'organonombre' => 'Revisoria Fiscal',
                        'organocorreo' => 'revisoriafiscal@gmail.com',
                        'organocelular' => '3006543212',
                        'organotelefono' => '6543212',
                        'organopqr' => 0,
                        'organoestado' => 1]);

        Organo::create(['conjuntoid' => 1,
                        'organonombre' => 'Consejo de Administración',
                        'organocorreo' => 'consejosiena@gmail.com',
                        'organocelular' => '3006543212',
                        'organotelefono' => '6543212',
                        'organopqr' => 1,
                        'organoestado' => 1]);

        Organo::create(['conjuntoid' => 1,
                        'organonombre' => 'Comite de Convivencia',
                        'organocorreo' => 'comiteconvivenciasiena@gmail.com',
                        'organocelular' => '3006543212',
                        'organotelefono' => '6543212',
                        'organopqr' => 1,
                        'organoestado' => 1]);

        Organo::create(['conjuntoid' => 1,
                        'organonombre' => 'Administración',
                        'organocorreo' => 'administracionsiena@gmail.com',
                        'organocelular' => '3006543212',
                        'organotelefono' => '6543212',
                        'organonivel' => 2,
                        'organopqr' => 1,
                        'organoestado' => 1]);

    }
}
