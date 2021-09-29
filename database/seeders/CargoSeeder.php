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
        Cargo::create(['cargonombre' => 'Revisor Fiscal','cargonivel' => 1,'cargopqr' => 0]);
        Cargo::create(['cargonombre' => 'Consejo de Administración (Presidente)','cargonivel' => 0,'cargopqr' => 1,'cargorole' => 7]);
        Cargo::create(['cargonombre' => 'Consejo de Administración (VicePresidente)','cargonivel' => 1,'cargopqr' => 0]);
        Cargo::create(['cargonombre' => 'Consejo de Administración (Secretario)','cargonivel' => 1,'cargopqr' => 0]);
        Cargo::create(['cargonombre' => 'Consejo de Administración (Delegado)','cargonivel' => 1,'cargopqr' => 0]);
        Cargo::create(['cargonombre' => 'Comite de Convivencia (Presidente)','cargonivel' => 1,'cargopqr' => 2,'cargorole' => 9]);
        Cargo::create(['cargonombre' => 'Comite de Convivencia (Secretario)','cargonivel' => 1,'cargopqr' => 0]);
        Cargo::create(['cargonombre' => 'Comite de Convivencia (Principal)','cargonivel' => 1,'cargopqr' => 0]);
        Cargo::create(['cargonombre' => 'Comite de Convivencia (Suplente)','cargonivel' => 1,'cargopqr' => 0]);

        Cargo::create(['cargonombre' => 'Administrador','cargonivel' => 1,'cargopqr' => 3,'cargorole' => 3]);

        Cargo::create(['cargonombre' => 'Contador','cargonivel' => 2,'cargopqr' => 0]);
        Cargo::create(['cargonombre' => 'Asistente','cargonivel' => 2,'cargopqr' => 0,'cargorole' => 6]);
        Cargo::create(['cargonombre' => 'Piscinero','cargonivel' => 2,'cargopqr' => 0,'cargorole' => 8]);
        Cargo::create(['cargonombre' => 'Salvavidas','cargonivel' => 2,'cargopqr' => 0]);
        Cargo::create(['cargonombre' => 'Entrenador','cargonivel' => 2,'cargopqr' => 0]);
        Cargo::create(['cargonombre' => 'Conserje','cargonivel' => 2,'cargopqr' => 0,'cargorole' => 4]);
        Cargo::create(['cargonombre' => 'Vigilante','cargonivel' => 2,'cargopqr' => 0,'cargorole' => 4]);
        Cargo::create(['cargonombre' => 'Oficios Varios','cargonivel' => 2,'cargopqr' => 0]);
    }
}
