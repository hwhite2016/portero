<?php

namespace Database\Seeders;

use App\Models\TipoNorma;
use Illuminate\Database\Seeder;

class NormaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoNorma::create(['tiponormanombre' => 'Reglamento']);
        TipoNorma::create(['tiponormanombre' => 'Estatuto']);
        TipoNorma::create(['tiponormanombre' => 'Norma']);
        TipoNorma::create(['tiponormanombre' => 'Manual']);
        TipoNorma::create(['tiponormanombre' => 'Procedimiento']);
        TipoNorma::create(['tiponormanombre' => 'Politica']);
        TipoNorma::create(['tiponormanombre' => 'Lineamiento']);
    }
}
