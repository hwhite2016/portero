<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role0 = Role::create(['name' => '_pendiente']);
        $role1 = Role::create(['name' => '_superadministrador']);
        $role2 = Role::create(['name' => '_administrador']);
        $role3 = Role::create(['name' => 'Seguridad']);
        $role5 = Role::create(['name' => 'Residente']);
        $role4 = Role::create(['name' => 'Asistente']);
        $role6 = Role::create(['name' => '_consejero']);
        $role7 = Role::create(['name' => 'Piscinero']);
        $role8 = Role::create(['name' => '_comiteconvivencia']);

        Permission::create(['name' => 'registros.edit', 'description' => 'Editar Registro'])->syncRoles([$role0]);

        Permission::create(['name' => 'admin.index', 'description' => 'Ver el dashboard'])->syncRoles([$role1, $role2, $role3, $role4, $role5, $role6, $role7, $role8]);

        Permission::create(['name' => 'admin.organos.estructura', 'description' => 'Ver el organigrama'])->syncRoles([$role1, $role2, $role3, $role4, $role5, $role6, $role7, $role8]);

        Permission::create(['name' => 'admin.normas.index', 'description' => 'Ver los documentos'])->syncRoles([$role1, $role2, $role3, $role4, $role5, $role6, $role7, $role8]);
        Permission::create(['name' => 'admin.normas.create', 'description' => 'Crear un documento'])->syncRoles([$role1, $role2, $role6]);
        Permission::create(['name' => 'admin.normas.edit', 'description' => 'Editar un documento'])->syncRoles([$role1, $role2, $role6]);
        Permission::create(['name' => 'admin.normas.destroy', 'description' => 'Eliminar un documento'])->syncRoles([$role1, $role2, $role6]);

        Permission::create(['name' => 'admin.personas.index', 'description' => 'Ver lista de personas'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.personas.create', 'description' => 'Crear personas'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.personas.edit', 'description' => 'Editar personas'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.personas.destroy', 'description' => 'Eliminar personas'])->syncRoles([$role1]);

        Permission::create(['name' => 'admin.users.index', 'description' => 'Ver lista de usuarios'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.users.create', 'description' => 'Crear usuarios'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.users.edit', 'description' => 'Agregar un rol'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.users.destroy', 'description' => 'Eliminar usuarios'])->syncRoles([$role1]);

        Permission::create(['name' => 'admin.empleados.index', 'description' => 'Ver lista de empleados'])->syncRoles([$role1, $role2, $role6]);
        Permission::create(['name' => 'admin.empleados.create', 'description' => 'Crear empleados'])->syncRoles([$role1, $role2, $role6]);
        Permission::create(['name' => 'admin.empleados.edit', 'description' => 'Editar empleados'])->syncRoles([$role1, $role2, $role6]);
        Permission::create(['name' => 'admin.empleados.destroy', 'description' => 'Eliminar empleados'])->syncRoles([$role1, $role2, $role6]);

        Permission::create(['name' => 'admin.roles.index', 'description' => 'Ver listado de roles'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.roles.create', 'description' => 'Crear roles'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.roles.edit', 'description' => 'Editar un rol'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.roles.destroy', 'description' => 'Eliminar un rol'])->syncRoles([$role1]);

        Permission::create(['name' => 'admin.pais.index', 'description' => 'Ver lista de paises'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.pais.create', 'description' => 'Crear un pais'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.pais.edit', 'description' => 'Editar un pais'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.pais.destroy', 'description' => 'Eliminar un pais'])->syncRoles([$role1]);

        Permission::create(['name' => 'admin.ciudads.index', 'description' => 'Ver lista de ciudades'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.ciudads.create', 'description' => 'Crear una ciuadad'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.ciudads.edit', 'description' => 'Editar una ciudad'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.ciudads.destroy', 'description' => 'Eliminar una ciudad'])->syncRoles([$role1]);

        Permission::create(['name' => 'admin.barrios.index', 'description' => 'Ver lista de barrios'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.barrios.create', 'description' => 'Crear un barrio'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.barrios.edit', 'description' => 'Editar un barrio'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.barrios.destroy', 'description' => 'Eliminar un barrio'])->syncRoles([$role1]);

        Permission::create(['name' => 'admin.condominios.index', 'description' => 'Ver lista de Condominios'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.condominios.create', 'description' => 'Crear un condominio'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.condominios.edit', 'description' => 'Editar un condominio'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.condominios.destroy', 'description' => 'Eliminar un condominio'])->syncRoles([$role1]);

        Permission::create(['name' => 'admin.organos.index', 'description' => 'Ver lista de organos'])->syncRoles([$role1, $role6]);
        Permission::create(['name' => 'admin.organos.create', 'description' => 'Crear un organo'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.organos.edit', 'description' => 'Editar un organo'])->syncRoles([$role1, $role6]);
        Permission::create(['name' => 'admin.organos.destroy', 'description' => 'Eliminar un organo'])->syncRoles([$role1]);

        Permission::create(['name' => 'admin.conjuntos.index', 'description' => 'Ver lista de conjuntos'])->syncRoles([$role1,$role2,$role3,$role4,$role5,$role6,$role8]);
        //Permission::create(['name' => 'admin.conjuntos.create', 'description' => 'Crear un conjunto'])->syncRoles([$role2]);
        Permission::create(['name' => 'admin.conjuntos.edit', 'description' => 'Editar un conjunto'])->syncRoles([$role1, $role2]);
        //Permission::create(['name' => 'admin.conjuntos.destroy', 'description' => 'Eliminar un conjunto'])->syncRoles([$role2]);

        Permission::create(['name' => 'admin.bloques.index', 'description' => 'Ver lista de bloques'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'admin.bloques.create', 'description' => 'Crear un bloque'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'admin.bloques.edit', 'description' => 'Editar un bloque'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'admin.bloques.destroy', 'description' => 'Eliminar un bloque'])->syncRoles([$role1, $role2]);

        Permission::create(['name' => 'admin.clase_unidads.index', 'description' => 'Ver listado de las clases de unidades'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'admin.clase_unidads.create', 'description' => 'Crear un clase de unidad'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'admin.clase_unidads.edit', 'description' => 'Editar una clase de unidad'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'admin.clase_unidads.destroy', 'description' => 'Eliminar una clase de unidad'])->syncRoles([$role1, $role2]);

        Permission::create(['name' => 'admin.unidads.index', 'description' => 'Ver listado de unidades'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'admin.unidads.create', 'description' => 'Crear una unidad'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'admin.unidads.edit', 'description' => 'Editar una unidad'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'admin.unidads.destroy', 'description' => 'Eliminar una unidad'])->syncRoles([$role1, $role2]);

        Permission::create(['name' => 'admin.residentes.index', 'description' => 'Ver listado de residentes'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'admin.residentes.create', 'description' => 'Crear un residente'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'admin.residentes.edit', 'description' => 'Editar un residente'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'admin.residentes.destroy', 'description' => 'Eliminar un residente'])->syncRoles([$role1, $role2]);

        Permission::create(['name' => 'admin.vehiculos.index', 'description' => 'Ver listado de vehiculos'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'admin.vehiculos.create', 'description' => 'Crear un vehiculo'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'admin.vehiculos.edit', 'description' => 'Editar un vehiculo'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'admin.vehiculos.destroy', 'description' => 'Eliminar un vehiculo'])->syncRoles([$role1, $role2]);

        Permission::create(['name' => 'admin.mascotas.index', 'description' => 'Ver listado de mascotas'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'admin.mascotas.create', 'description' => 'Crear una mascota'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'admin.mascotas.edit', 'description' => 'Editar una mascota'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'admin.mascotas.destroy', 'description' => 'Eliminar una mascota'])->syncRoles([$role1, $role2]);

        Permission::create(['name' => 'admin.parqueaderos.index', 'description' => 'Ver listado de parqueaderos'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'admin.parqueaderos.create', 'description' => 'Crear un parqueadero'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'admin.parqueaderos.edit', 'description' => 'Editar un parqueadero'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'admin.parqueaderos.destroy', 'description' => 'Eliminar un parqueadero'])->syncRoles([$role1, $role2]);

        Permission::create(['name' => 'admin.zonas.index', 'description' => 'Ver listado de zonas'])->syncRoles([$role1, $role2, $role5]);
        Permission::create(['name' => 'admin.zonas.create', 'description' => 'Crear un zona comun'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'admin.zonas.edit', 'description' => 'Editar un zona comun'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'admin.zonas.destroy', 'description' => 'Eliminar una zona comun'])->syncRoles([$role1, $role2]);
        //Permission::create(['name' => 'admin.zonas.zonacomun', 'description' => 'Reservar Zonas comunes'])->syncRoles([$role5]);

        Permission::create(['name' => 'admin.visitantes.index', 'description' => 'Ver listado de visitantes'])->syncRoles([$role1, $role2, $role3, $role5]);
        Permission::create(['name' => 'admin.visitantes.create', 'description' => 'Crear un visitante'])->syncRoles([$role1, $role3, $role5]);
        Permission::create(['name' => 'admin.visitantes.edit', 'description' => 'Editar un visitante'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.visitantes.destroy', 'description' => 'Dar salida un visitante'])->syncRoles([$role1, $role3]);
        Permission::create(['name' => 'admin.visitantes.restaurar', 'description' => 'Restaurar un visitante'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.visitantes.hdestroy', 'description' => 'Eliminar un visitante'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.visitantes.getVisitantes', 'description' => 'Ver listado de hist. de visitantes'])->syncRoles([$role1, $role2, $role3]);

        Permission::create(['name' => 'admin.entregas.index', 'description' => 'Ver listado de entregas'])->syncRoles([$role1, $role2, $role3]);
        Permission::create(['name' => 'admin.entregas.create', 'description' => 'Recibir un paquete'])->syncRoles([$role1, $role3]);
        Permission::create(['name' => 'admin.entregas.edit', 'description' => 'Entregar paquetes'])->syncRoles([$role1, $role3, $role5]);
        Permission::create(['name' => 'admin.entregas.destroy', 'description' => 'Eliminar un entrega'])->syncRoles([$role1]);

        Permission::create(['name' => 'admin.seguimiento.index', 'description' => 'Ver correspondencia'])->syncRoles([$role1, $role5]);
        Permission::create(['name' => 'admin.seguimiento.edit', 'description' => 'Confirmar correspondencia'])->syncRoles([$role1, $role5]);

        Permission::create(['name' => 'admin.pqrs.index', 'description' => 'Ver los pqrs'])->syncRoles([$role1, $role2, $role8, $role5, $role6]);
        Permission::create(['name' => 'admin.pqrs.create', 'description' => 'Crear un pqrs'])->syncRoles([$role1, $role5]);
        Permission::create(['name' => 'admin.pqrs.edit', 'description' => 'Editar un pqrs'])->syncRoles([$role1, $role2, $role8, $role5, $role6]);
        Permission::create(['name' => 'admin.pqrs.destroy', 'description' => 'Eliminar un pqrs'])->syncRoles([$role1, $role2, $role8, $role6]);

        Permission::create(['name' => 'admin.reservas.index', 'description' => 'Ver mis reservas'])->syncRoles([$role1, $role2, $role5]);
        Permission::create(['name' => 'admin.reservas.create', 'description' => 'Crear un reserva'])->syncRoles([$role1, $role2, $role5]);
        Permission::create(['name' => 'admin.reservas.edit', 'description' => 'Editar un reserva'])->syncRoles([$role1, $role2 , $role5]);
        Permission::create(['name' => 'admin.reservas.destroy', 'description' => 'Eliminar un reserva'])->syncRoles([$role1, $role2, $role5]);

        Permission::create(['name' => 'admin.notificaciones.show', 'description' => 'Ver Notificaciones'])->syncRoles([$role1, $role5]);

    }
}
