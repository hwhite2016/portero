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
        $conjunto->conjuntonit = 123456789;
        $conjunto->conjuntonombre = 'Conjunto Residencial Siena';
        $conjunto->conjuntodireccion = 'Transversal 44 # 102 - 167';
        $conjunto->conjuntologo = 'logos/20210925112647.jpg';
        $conjunto->conjuntocorreo = 'conjunto.siena@gmail.com';
        $conjunto->conjuntocorreoconsejo = 'consejo.siena@gmail.com';
        $conjunto->conjuntocorreocomite = 'comiteconvivencia.siena@gmail.com';
        $conjunto->conjuntocelular = '3008765432';
        $conjunto->conjuntotelefono = '2334556';
        $conjunto->conjuntoestado = 1;

        $conjunto->save();

        $conjunto2 = new Conjunto();

        $conjunto2->barrioid = 1;
        $conjunto2->conjuntonit = 987654321;
        $conjunto2->conjuntonombre = 'Conjunto Residencial Olivenza';
        $conjunto2->conjuntodireccion = 'Transversal 44 # 102 - 167';
        $conjunto2->conjuntologo = 'logos/20210614115737.jpg';
        $conjunto2->conjuntocorreo = 'conjunto.olivenza@gmail.com';
        $conjunto->conjuntocorreoconsejo = 'consejo.olivenza@gmail.com';
        $conjunto->conjuntocorreocomite = 'comiteconvivencia.olivenza@gmail.com';
        $conjunto2->conjuntocelular = '3008765432';
        $conjunto2->conjuntotelefono = '2334556';
        $conjunto2->conjuntoestado = 1;

        $conjunto2->save();
    }
}
