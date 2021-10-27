<?php

namespace Database\Seeders;

use App\Models\Relation;
use App\Models\TipoPropietario;
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
        TipoPropietario::create(['tipopropietarionombre' => 'Propietario']);
        TipoPropietario::create(['tipopropietarionombre' => 'Locatario']);
        TipoPropietario::create(['tipopropietarionombre' => 'Inmobiliaria']);

        TipoResidente::create(['tiporesidentenombre' => 'Propietario / Locatario']);
        TipoResidente::create(['tiporesidentenombre' => 'Arrendatario']);
        TipoResidente::create(['tiporesidentenombre' => 'Servicio Domestico']);
        TipoResidente::create(['tiporesidentenombre' => 'Huespéd temporal']);

        Relation::create(['relationname' => 'Titular']);
        Relation::create(['relationname' => 'Esposo(a) del titular']);
        Relation::create(['relationname' => 'Hijo(a) del titular']);
        Relation::create(['relationname' => 'Padre del titular']);
        Relation::create(['relationname' => 'Madre del titular']);
        Relation::create(['relationname' => 'Hermano(a) del titular']);
        Relation::create(['relationname' => 'Abuelo(a) del titular']);
        Relation::create(['relationname' => 'Nieto(a) del titular']);
        Relation::create(['relationname' => 'Tio(a) del titular']);
        Relation::create(['relationname' => 'Sobrino(a) del titular']);
        Relation::create(['relationname' => 'Primo(a) del titular']);
        Relation::create(['relationname' => 'Suegro(a) del titular']);
        Relation::create(['relationname' => 'Nuero(a) del titular']);
        Relation::create(['relationname' => 'Amigo(a) del titular']);
        Relation::create(['relationname' => 'Otro']);
    }
}
