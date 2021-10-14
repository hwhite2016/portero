<?php

namespace Database\Seeders;

use App\Models\Cargo;
use Illuminate\Database\Seeder;

class CargoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Cargo::create(['cargonombre' => 'Revisor Fiscal','cargonivel' => 1]);
        Cargo::create(['cargonombre' => 'Asesor Juridico','cargonivel' => 1]);
        Cargo::create(['cargonombre' => 'Presidente del Consejo','cargonivel' => 0,'cargorole' => 7]);
        Cargo::create(['cargonombre' => 'VicePresidente del Consejo','cargonivel' => 1,'cargorole' => 7]);
        Cargo::create(['cargonombre' => 'Secretario del Consejo','cargonivel' => 1]);
        Cargo::create(['cargonombre' => 'Tesorero del Consejo','cargonivel' => 1]);
        Cargo::create(['cargonombre' => 'Vocal del Consejo','cargonivel' => 1]);
        Cargo::create(['cargonombre' => 'Delegado del Consejo','cargonivel' => 1]);
        Cargo::create(['cargonombre' => 'Miembro del Comite','cargonivel' => 1,'cargorole' => 9]);

        Cargo::create(['cargonombre' => 'Administrador','cargonivel' => 1,'cargorole' => 3]);

        Cargo::create(['cargonombre' => 'Contador','cargonivel' => 2]);
        Cargo::create(['cargonombre' => 'Asistente','cargonivel' => 2,'cargorole' => 6]);
        Cargo::create(['cargonombre' => 'Piscinero','cargonivel' => 2,'cargorole' => 8]);
        Cargo::create(['cargonombre' => 'Salvavidas','cargonivel' => 2]);
        Cargo::create(['cargonombre' => 'Entrenador','cargonivel' => 2]);
        Cargo::create(['cargonombre' => 'Conserje','cargonivel' => 2,'cargorole' => 4]);
        Cargo::create(['cargonombre' => 'Vigilante','cargonivel' => 2,'cargorole' => 4]);
        Cargo::create(['cargonombre' => 'Oficios Varios','cargonivel' => 2]);
    }
}
