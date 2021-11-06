<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Persona;
use App\Models\TipoDocumento;

class PersonaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoDocumento::create([
            'tipodocumentonombre' => 'Cedula de Ciudadania',
            'tipodocumentoabreviatura' => 'CC'
        ]);

        TipoDocumento::create([
            'tipodocumentonombre' => 'Registro Civil',
            'tipodocumentoabreviatura' => 'RC'
        ]);

        TipoDocumento::create([
            'tipodocumentonombre' => 'Tarjeta de Identidad',
            'tipodocumentoabreviatura' => 'TI'
        ]);

        TipoDocumento::create([
            'tipodocumentonombre' => 'Cedula de Extranjeria',
            'tipodocumentoabreviatura' => 'CE'
        ]);

        TipoDocumento::create([
            'tipodocumentonombre' => 'NIT',
            'tipodocumentoabreviatura' => 'NIT'
        ]);

        TipoDocumento::create([
            'tipodocumentonombre' => 'Pasaporte',
            'tipodocumentoabreviatura' => 'PA'
        ]);

        TipoDocumento::create([
            'tipodocumentonombre' => 'Carnet Diplomatico',
            'tipodocumentoabreviatura' => 'CD'
        ]);


        Persona::create([
            'tipodocumentoid' => 1,
            'personadocumento' => '7143433',
            'personanombre' => 'Victor Lopez',
            'personafechanacimiento' => '19791201',
            'personacorreo' => 'victor@wikisoft.co',
            'personacelular' => '3007424455'
        ]);

        Persona::create([
            'tipodocumentoid' => 1,
            'personadocumento' => '7777777',
            'personanombre' => 'Heisenberg',
            'personafechanacimiento' => '19821201',
            'personacorreo' => 'hw@wikisoft.co',
            'personacelular' => '3007424455'
        ]);

        Persona::create([
            'tipodocumentoid' => 1,
            'personadocumento' => '1140817467',
            'personanombre' => 'Eliana Solipa',
            'personafechanacimiento' => '19821201',
            'personacorreo' => 'eliana@wikisoft.co',
            'personacelular' => '3007424455'
        ]);

        Persona::create([
            'tipodocumentoid' => 3,
            'personadocumento' => '1236888251',
            'personanombre' => 'Eimy Lopez',
            'personafechanacimiento' => '20180726',
            'personacorreo' => 'eimy@wikisoft.co',
            'personacelular' => '3007424455'
        ]);

        Persona::create([
            'tipodocumentoid' => 1,
            'personadocumento' => '123456',
            'personanombre' => 'Edith Genoveva Criales',
            'personafechanacimiento' => '19650726',
            'personacorreo' => 'edith@wikisoft.co',
            'personacelular' => '3204526989'
        ]);


    }
}
