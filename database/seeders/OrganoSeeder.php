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
        Organo::create(['organonombre' => 'Revisoria Fiscal','organonombrecorto' => 'revisoriafiscal@gmail.com','organonivel' => 1]);
        Organo::create(['organonombre' => 'Consejo de Administración','organonombrecorto' => 'revisoriafiscal@gmail.com','organonivel' => 1]);
        Organo::create(['organonombre' => 'Comite de Convivencia','organonombrecorto' => 'revisoriafiscal@gmail.com','organonivel' => 1]);
        Organo::create(['organonombre' => 'Administración','organonombrecorto' => 'revisoriafiscal@gmail.com','organonivel' => 2]);



    }
}
