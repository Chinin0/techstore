<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


use Spatie\Permission\Models\Permission;


class SeederTablaPermisos extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $permisos = [

         //tabla de roles
             'ver-rol',
             'crear-rol',
             'editar-rol',
             'borrar-rol',
         //tabla de usuarios
             'ver-user',
             'crear-user',
             'editar-user',
             'borrar-user',
         //tabla de blogs
             'ver-blog',
             'crear-blog',
             'editar-blog',
             'borrar-blog',
        //tabla de persona
            'ver-persona',
            'crear-persona',
            'editar-persona',
            'borrar-persona',
        //tabla de paciente
            'ver-paciente',
            'crear-paciente',
            'editar-paciente',
            'borrar-paciente',
         //tabla de producto
            'ver-producto',
            'crear-producto',
            'editar-producto',
            'borrar-producto',
         //tabla de ingreso
            'ver-ingreso',
            'crear-ingreso',
            'editar-ingreso',
            'borrar-ingreso',
         //tabla de categoria
            'ver-categoria',
            'crear-categoria',
            'editar-categoria',
            'borrar-categoria',
         //tabla de contrato
            'ver-contrato',
            'crear-contrato',
            'editar-contrato',
            'borrar-contrato',
         //tabla de activo
            'ver-activo',
            'crear-activo',
            'editar-activo',
            'borrar-activo',
         //tabla de INVENTARIO
            'ver-inventario',
            'crear-inventario',
            'editar-inventario',
            'borrar-inventario',
         //tabla de tipo_servicio
            'ver-tipo_servicio',
            'crear-tipo_servicio',
            'editar-tipo_servicio',
            'borrar-tipo_servicio',
         //tabla de servicio
            'ver-servicio',
            'crear-servicio',
            'editar-servicio',
            'borrar-servicio',
         //tabla de Pago
            'ver-pago',
            'crear-pago',
            'editar-pago',
            'borrar-pago',
         //Ventas
            'ver-venta',
];


         foreach($permisos as $permiso){
            $existe = Permission::where('name', $permiso)->first();

            if (!$existe) {
             Permission::create(['name'=>$permiso]);
            }

         }

     }
}
