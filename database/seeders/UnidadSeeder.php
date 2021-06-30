<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TipoUnidad;
use App\Models\ClaseUnidad;
use App\Models\Unidad;

class UnidadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoUnidad::create(['tipounidadnombre' => 'Apartamento']);
        TipoUnidad::create(['tipounidadnombre' => 'Casa']);


        ClaseUnidad::create(['conjuntoid' => 1, 'claseunidadnombre' => 'Tipo A',
                             'claseunidaddescripcion' => '72 mts2', 'claseunidadcuota' => 173000]);
        ClaseUnidad::create(['conjuntoid' => 1, 'claseunidadnombre' => 'Tipo B',
                             'claseunidaddescripcion' => '65 mts2', 'claseunidadcuota' => 142000]);
        ClaseUnidad::create(['conjuntoid' => 2, 'claseunidadnombre' => 'Tipo A',
                             'claseunidaddescripcion' => '96 mts2', 'claseunidadcuota' => 191000]);
        ClaseUnidad::create(['conjuntoid' => 2, 'claseunidadnombre' => 'Tipo B',
                             'claseunidaddescripcion' => '81 mts2', 'claseunidadcuota' => 176000]);


        Unidad::create(['bloqueid' => 1, 'claseunidadid' => 1, 'unidadnombre' => 'Apartamento 104']);
        Unidad::create(['bloqueid' => 1, 'claseunidadid' => 2, 'unidadnombre' => 'Apartamento 448']);
        Unidad::create(['bloqueid' => 3, 'claseunidadid' => 1, 'unidadnombre' => 'Apartamento 108']);
        Unidad::create(['bloqueid' => 4, 'claseunidadid' => 2, 'unidadnombre' => 'Apartamento 654']);
        Unidad::create(['bloqueid' => 5, 'claseunidadid' => 1, 'unidadnombre' => 'Apartamento 1021']);
        Unidad::create(['bloqueid' => 6, 'claseunidadid' => 1, 'unidadnombre' => 'Apartamento 348']);
        Unidad::create(['bloqueid' => 7, 'claseunidadid' => 3, 'unidadnombre' => 'Apartamento 101']);
        Unidad::create(['bloqueid' => 7, 'claseunidadid' => 3, 'unidadnombre' => 'Apartamento 102']);
        Unidad::create(['bloqueid' => 7, 'claseunidadid' => 4, 'unidadnombre' => 'Apartamento 103']);
        Unidad::create(['bloqueid' => 8, 'claseunidadid' => 3, 'unidadnombre' => 'Apartamento 214']);
    }
}
