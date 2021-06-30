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

        Relation::create(['relationname' => 'Principal (Cabeza)']);
        Relation::create(['relationname' => 'Esposo(a)']);
        Relation::create(['relationname' => 'Hijo(a)']);
        Relation::create(['relationname' => 'Abuelo(a)']);
        Relation::create(['relationname' => 'Familiar']);
        Relation::create(['relationname' => 'Otro']);
    }
}
