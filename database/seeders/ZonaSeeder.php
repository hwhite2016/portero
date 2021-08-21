<?php

namespace Database\Seeders;

use App\Models\EstadoZona;
use App\Models\Zona;
use Illuminate\Database\Seeder;

class ZonaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Zona::create(['conjuntoid' => 1, 'zonanombre' => 'Piscina para niños',
            'zonaimagen'=>'1/zonas/20210614115730.jpg',
            'zonadescripcion' => 'Zona de diversion para todos los niños',
            'zonaterminos'=>'El COPROPIETARIO deberá hacer uso obligatorio de: vestido de baño en material apropiado, utilizar el vestier, cumplir con las buenas prácticas sanitarias.
             Se prohíbe: el ingreso a menores de doce (12) años sin el acompañamiento de un adulto responsable, el uso de la piscina a personas con heridas visibles, laceraciones o infecciones en la piel, el ingreso a la piscina en estado de embriaguez o bajo el efecto de sustancias psicoactivas, el consumo de alimentos, bebidas o fumar en la zona de piscina así como el ingreso de botellas de vidrio, el ingreso a los usuarios que porten cadenas, collares, camisetas o elementos similares que permitan el atrapamiento mecánico, así como el uso de cremas, cosméticos o aceites de cualquier tipo, la práctica de actividades de contacto dentro y fuera de la piscina, tales como clavados, carreras y juegos violentos.',
            'zonareservable'=>1,
            'zonafranjatiempo'=>'01:30:00',
            'zonahoraapertura'=>'10:00',
            'zonahoracierre'=>'18:00',
            'zonaaforomax'=> 15,
            'zonacuporeservamax'=> 3,
            'zonatiemporeservamax'=> 3,
            'zonareservadiariamax'=> 1,
            'zonaprecio'=> 0,
            'zonamorosos'=> 0
        ]);
        Zona::create(['conjuntoid' => 1, 'zonanombre' => 'Piscina para adultos',
            'zonaimagen'=>'1/zonas/20210614115731.jpg',
            'zonadescripcion' => 'Zona de diversion para todos los adultos',
            'zonaterminos'=>'El COPROPIETARIO deberá hacer uso obligatorio de: vestido de baño en material apropiado, utilizar el vestier, cumplir con las buenas prácticas sanitarias.
             Se prohíbe: el ingreso a menores de doce (12) años sin el acompañamiento de un adulto responsable, el uso de la piscina a personas con heridas visibles, laceraciones o infecciones en la piel, el ingreso a la piscina en estado de embriaguez o bajo el efecto de sustancias psicoactivas, el consumo de alimentos, bebidas o fumar en la zona de piscina así como el ingreso de botellas de vidrio, el ingreso a los usuarios que porten cadenas, collares, camisetas o elementos similares que permitan el atrapamiento mecánico, así como el uso de cremas, cosméticos o aceites de cualquier tipo, la práctica de actividades de contacto dentro y fuera de la piscina, tales como clavados, carreras y juegos violentos.',
            'zonareservable'=>1,
            'zonafranjatiempo'=>'01:30:00',
            'zonahoraapertura'=>'10:00',
            'zonahoracierre'=>'18:00',
            'zonaaforomax'=> 15,
            'zonacuporeservamax'=> 3,
            'zonatiemporeservamax'=> 3,
            'zonareservadiariamax'=> 1,
            'zonaprecio'=> 0,
            'zonamorosos'=> 0
        ]);
        Zona::create(['conjuntoid' => 1, 'zonanombre' => 'Parque infantil',
            'zonaimagen'=>'1/zonas/20210614115732.jpg',
            'zonadescripcion' => 'Zona de diversion para todos los niños',
            'zonaterminos'=>'Terminos y condiciones de uso para el parque infantil',
            'zonareservable'=>0,
            'zonafranjatiempo'=>'01:30:00',
            'zonahoraapertura'=>'07:00',
            'zonahoracierre'=>'22:00',
            'zonaaforomax'=> 15,
            'zonacuporeservamax'=> 3,
            'zonatiemporeservamax'=> 3,
            'zonareservadiariamax'=> 1,
            'zonaprecio'=> 0,
            'zonamorosos'=> 0
        ]);
        Zona::create(['conjuntoid' => 1, 'zonanombre' => 'Gimnasio',
            'zonaimagen'=>'1/zonas/20210614115733.jpg',
            'zonadescripcion' => 'Zona de diversion para todos los niños',
            'zonaterminos'=>'Las pesas y demás piezas sueltas de equipos, solo podrán ser utilizadas en las áreas destinadas para tal efecto y de acuerdo a las condiciones establecidas para su uso. Si algún AFILIADO considera que uno de los equipos está funcionando de forma deficiente, deberá informar esta situación al Administrador(a)',
            'zonareservable'=>0,
            'zonafranjatiempo'=>'01:00:00',
            'zonahoraapertura'=>'04:00',
            'zonahoracierre'=>'23:00',
            'zonaaforomax'=> 4,
            'zonacuporeservamax'=> 2,
            'zonatiemporeservamax'=> 2,
            'zonareservadiariamax'=> 1,
            'zonaprecio'=> 0,
            'zonamorosos'=> 0
        ]);
        Zona::create(['conjuntoid' => 1, 'zonanombre' => 'Sauna',
            'zonaimagen'=>'1/zonas/20210614115734.jpg',
            'zonadescripcion' => 'Baño de vapor, el complemento perfecto a nuestro entrenamiento diario.',
            'zonaterminos'=>'Terminos y condiciones de uso para el sauna',
            'zonareservable'=>1,
            'zonafranjatiempo'=>'01:00:00',
            'zonahoraapertura'=>'04:00',
            'zonahoracierre'=>'21:00',
            'zonaaforomax'=> 4,
            'zonacuporeservamax'=> 2,
            'zonatiemporeservamax'=> 2,
            'zonareservadiariamax'=> 1,
            'zonaprecio'=> 0,
            'zonamorosos'=> 0
        ]);
        Zona::create(['conjuntoid' => 1, 'zonanombre' => 'Salon de Eventos 1',
            'zonaimagen'=>'1/zonas/20210614115736.jpg',
            'zonadescripcion' => 'Apto para cumpleaños, matrimonios, quinceañeros y fiestas en general.',
            'zonaterminos'=>'Terminos y condiciones de uso para salones de eventos',
            'zonareservable'=>1,
            'zonafranjatiempo'=>'02:00:00',
            'zonahoraapertura'=>'08:00',
            'zonahoracierre'=>'23:00',
            'zonaaforomax'=> 30,
            'zonacuporeservamax'=> 2,
            'zonatiemporeservamax'=> 2,
            'zonareservadiariamax'=> 2,
            'zonaprecio'=> 80000,
            'zonamorosos'=> 0
        ]);
        Zona::create(['conjuntoid' => 1, 'zonanombre' => 'Salon de Eventos 2',
            'zonaimagen'=>'1/zonas/20210614115736.jpg',
            'zonadescripcion' => 'Apto para cumpleaños, matrimonios, quinceañeros y fiestas en general.',
            'zonaterminos'=>'Terminos y condiciones de uso para salones de eventos',
            'zonareservable'=>1,
            'zonafranjatiempo'=>'02:00:00',
            'zonahoraapertura'=>'08:00',
            'zonahoracierre'=>'23:00',
            'zonaaforomax'=> 30,
            'zonacuporeservamax'=> 2,
            'zonatiemporeservamax'=> 2,
            'zonareservadiariamax'=> 2,
            'zonaprecio'=> 80000,
            'zonamorosos'=> 0
        ]);
        Zona::create(['conjuntoid' => 1, 'zonanombre' => 'Salon de Eventos 3',
            'zonaimagen'=>'1/zonas/20210614115736.jpg',
            'zonadescripcion' => 'Apto para cumpleaños, matrimonios, quinceañeros y fiestas en general.',
            'zonaterminos'=>'Terminos y condiciones de uso para salones de eventos',
            'zonareservable'=>1,
            'zonafranjatiempo'=>'02:00:00',
            'zonahoraapertura'=>'08:00',
            'zonahoracierre'=>'23:00',
            'zonaaforomax'=> 30,
            'zonacuporeservamax'=> 2,
            'zonatiemporeservamax'=> 2,
            'zonareservadiariamax'=> 2,
            'zonaprecio'=> 80000,
            'zonamorosos'=> 0
        ]);
        Zona::create(['conjuntoid' => 1, 'zonanombre' => 'Teatrino',
            'zonaimagen'=>'1/zonas/20210614115735.jpg',
            'zonadescripcion' => 'Disfruta de este este espacio para ver peliculas como en el cine.',
            'zonaterminos'=>'Terminos y condiciones de uso para cines o teatros',
            'zonareservable'=>1,
            'zonafranjatiempo'=>'02:00:00',
            'zonahoraapertura'=>'09:00',
            'zonahoracierre'=>'23:00',
            'zonaaforomax'=> 10,
            'zonacuporeservamax'=> 10,
            'zonatiemporeservamax'=> 7,
            'zonareservadiariamax'=> 1,
            'zonaprecio'=> 50000,
            'zonamorosos'=> 0
        ]);
    }
}
