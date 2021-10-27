<?php

namespace Database\Seeders;

use App\Models\EstadoRegistro;
use Illuminate\Database\Seeder;

class EstadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EstadoRegistro::create(['estadonombre' => 'Sin registro']);
        EstadoRegistro::create(['estadonombre' => 'En proceso']);
        EstadoRegistro::create(['estadonombre' => 'Por verificar']);
        EstadoRegistro::create(['estadonombre' => 'Verificado']);
    }
}
