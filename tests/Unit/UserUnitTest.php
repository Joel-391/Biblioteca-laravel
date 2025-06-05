<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Rol; // Importar el modelo de Rol
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class UserUnitTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function Correcta_Creacion_De_Usuario()
    {
        // Crear un rol en la tabla roles
        $rol = Rol::create([
            'nombre_rol' => 'Usuario',
            'descripcion' => 'Rol estándar para usuarios',
            'nivel_prioridad' => 1,
            'activo' => true
        ]);

        // Crear un usuario con rol_id
        $user = User::create([
            'name' => 'Carlos Johan',
            'email' => 'carlos@example.com',
            'password' => bcrypt('password123'), // Asegúrate de encriptar la contraseña
            'rol_id' => $rol->id, // Asocia el rol al usuario
        ]);

        // Verificar que el usuario se guardó en la base de datos
        $this->assertDatabaseHas('users', [
            'name' => 'Carlos Johan',
            'email' => 'carlos@example.com',
            'rol_id' => $rol->id, // Verifica que el rol_id está correctamente asignado
        ]);
    }
}
