<?php

namespace Database\Seeders;

use App\Models\Relation;
use Illuminate\Database\Seeder;
use App\Models\TipoResidente;

class ResidenteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoResidente::create(['tiporesidentenombre' => 'Propietario']);
        TipoResidente::create(['tiporesidentenombre' => 'Arrendatario']);
        TipoResidente::create(['tiporesidentenombre' => 'Inquilino']);
        TipoResidente::create(['tiporesidentenombre' => 'Servicio Domestico']);
        //TipoResidente::create(['tiporesidentenombre' => 'Otros']);

        Relation::create(['relationname' => 'Titular']);
        Relation::create(['relationname' => 'Esposo(a)']);
        Relation::create(['relationname' => 'Hijo(a)']);
        Relation::create(['relationname' => 'Padre']);
        Relation::create(['relationname' => 'Madre']);
        Relation::create(['relationname' => 'Hermano(a)']);
        Relation::create(['relationname' => 'Abuelo(a)']);
        Relation::create(['relationname' => 'Nieto(a)']);
        Relation::create(['relationname' => 'Tio(a)']);
        Relation::create(['relationname' => 'Primo(a)']);
        Relation::create(['relationname' => 'Suegro(a)']);
        Relation::create(['relationname' => 'Otro']);
    }
}
