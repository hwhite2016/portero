<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(PersonaSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
    	$this->call(PaisSeeder::class);
    	$this->call(CiudadSeeder::class);
    	$this->call(BarrioSeeder::class);
    	$this->call(ConjuntoSeeder::class);
        $this->call(PersonaConjuntoSeeder::class);
    	$this->call(BloqueSeeder::class);
        $this->call(ParqueaderoSeeder::class);
        $this->call(UnidadSeeder::class);
        $this->call(UnidadParqueaderoSeeder::class);
        $this->call(ResidenteSeeder::class);
        $this->call(VehiculoSeeder::class);
        $this->call(MascotaSeeder::class);
        $this->call(EntregaSeeder::class);
        $this->call(ZonaSeeder::class);

    }
}
