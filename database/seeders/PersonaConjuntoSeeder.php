<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PersonaConjunto;

class PersonaConjuntoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PersonaConjunto::create(['persona_id' => '1', 'conjunto_id'=>'1']);
        PersonaConjunto::create(['persona_id' => '1', 'conjunto_id'=>'2']);
        PersonaConjunto::create(['persona_id' => '2', 'conjunto_id'=>'1']);

    }
}
