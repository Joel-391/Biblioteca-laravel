<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Rol;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Rol::insert([
            [
                'nombre_rol' => 'Estudiante',
                'descripcion' => 'Rol básico por defecto',
                'nivel_prioridad' => 3,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre_rol' => 'Secretario',
                'descripcion' => 'Rol medio',
                'nivel_prioridad' => 2,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre_rol' => 'Administrador',
                'descripcion' => 'Acceso completo al sistema',
                'nivel_prioridad' => 1,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
