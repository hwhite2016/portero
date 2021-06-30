<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Conjunto;

class ConjuntoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $conjunto = new Conjunto();

        $conjunto->barrioid = 1;
        $conjunto->conjuntonombre = 'Conjunto Residencial Siena';
        $conjunto->conjuntodireccion = 'Transversal 44 # 102 - 167';
        $conjunto->conjuntologo = 'logos/20210614115730.jpg';
        $conjunto->conjuntocorreo = 'siena@gmail.com';
        $conjunto->conjuntocelular = '3008765432';
        $conjunto->conjuntotelefono = '2334556';
        $conjunto->conjuntoestado = 1;

        $conjunto->save();

        $conjunto2 = new Conjunto();

        $conjunto2->barrioid = 1;
        $conjunto2->conjuntonombre = 'Conjunto Residencial Olivenza';
        $conjunto2->conjuntodireccion = 'Transversal 44 # 102 - 167';
        $conjunto2->conjuntologo = 'logos/20210614115737.jpg';
        $conjunto2->conjuntocorreo = 'olivenza@gmail.com';
        $conjunto2->conjuntocelular = '3008765432';
        $conjunto2->conjuntotelefono = '2334556';
        $conjunto2->conjuntoestado = 1;

        $conjunto2->save();
    }
}
