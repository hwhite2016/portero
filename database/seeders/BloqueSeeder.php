<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bloque;
use App\Models\TipoBloque;

class BloqueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        TipoBloque::create(['tipobloquenombre' => 'Torre']);
        TipoBloque::create(['tipobloquenombre' => 'Bloque']);
        TipoBloque::create(['tipobloquenombre' => 'Etapa']);
        TipoBloque::create(['tipobloquenombre' => 'Manzana']);


        Bloque::create(['conjuntoid' => 1, 'bloquenombre' => 'Torre 1']);
        Bloque::create(['conjuntoid' => 1, 'bloquenombre' => 'Torre 2']);
        Bloque::create(['conjuntoid' => 1, 'bloquenombre' => 'Torre 3']);
        Bloque::create(['conjuntoid' => 1, 'bloquenombre' => 'Torre 4']);
        Bloque::create(['conjuntoid' => 1, 'bloquenombre' => 'Torre 5']);
        Bloque::create(['conjuntoid' => 1, 'bloquenombre' => 'Torre 6']);

        Bloque::create(['conjuntoid' => 2, 'bloquenombre' => 'Torre 1']);
        Bloque::create(['conjuntoid' => 2, 'bloquenombre' => 'Torre 2']);

    }
}
