<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'personaid' => 1,
            'name' => 'Victor Lopez',
            'email' => 'victor@wikisoft.co',
            'password' => bcrypt('victor12345')
        ])->assignRole('_superadministrador');

        User::create([
            'personaid' => 2,
        	'name' => 'Heisenberg',
        	'email' => 'hw@wikisoft.co',
        	'password' => bcrypt('hw12345')
        ])->assignRole('_administrador');

        User::create([
            'personaid' => 3,
        	'name' => 'Eliana Solipa',
        	'email' => 'eliana@wikisoft.co',
        	'password' => bcrypt('eliana12345')
        ])->assignRole('Seguridad');

        User::create([
            'personaid' => 4,
        	'name' => 'Eimy Lopez',
        	'email' => 'eimy@wikisoft.co',
        	'password' => bcrypt('eimy12345')
        ])->assignRole('Residente');

        User::create([
            'personaid' => 5,
        	'name' => 'Edith Genoveva Criales',
        	'email' => 'edith@wikisoft.co',
        	'password' => bcrypt('edith12345')
        ])->assignRole('_administrador');

    }
}
