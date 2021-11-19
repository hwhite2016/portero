<?php

namespace Database\Seeders;

use App\Models\TipoAnuncio;
use Illuminate\Database\Seeder;

class AnuncioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoAnuncio::create(['tipoanuncionombre' => 'Anuncio']);
        TipoAnuncio::create(['tipoanuncionombre' => 'Invitación']);
        TipoAnuncio::create(['tipoanuncionombre' => 'Llamado de Atención']);
        TipoAnuncio::create(['tipoanuncionombre' => 'Recordatorio']);
    }
}
