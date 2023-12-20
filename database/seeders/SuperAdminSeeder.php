<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $usuario = User::create([
            'name' => 'grupo27sa',
            'email' => 'grupo27sa@tecnoweb.org',
            'password' => bcrypt('12345678'),
        ]);

        // Creando rol super administrador
        $rol = Role::create(['name' => 'root']);

        // Asignando todos los permisos
        $permisos = Permission::pluck('id', 'id')->all();
        $rol->syncPermissions($permisos);

        // Asignando rol al super usuario
        $usuario->assignRole([$rol->name]);
    }
}
