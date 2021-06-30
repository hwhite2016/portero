<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TipoEntrega;

class EntregaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoEntrega::create(['tipoentreganombre' => 'Domicilio', 'tipoentregaicono' => 'fas fa-shopping-basket mr-2']);
        TipoEntrega::create(['tipoentreganombre' => 'Paquete', 'tipoentregaicono' => 'fas fa-shipping-fast mr-2']);
        TipoEntrega::create(['tipoentreganombre' => 'Factura', 'tipoentregaicono' => 'fas fa-money-check mr-2']);
        TipoEntrega::create(['tipoentreganombre' => 'Documento', 'tipoentregaicono' => 'far fa-file-alt mr-2']);
    }
}
