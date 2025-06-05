<?php

namespace Tests\Feature;

use App\Models\Rol;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;


class AuthTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function Con_Acceso_Por_Token_Valido()
    {
        $rol = Rol::create([
            'nombre_rol' => 'Usuario',
            'descripcion' => 'Rol estándar para usuarios',
            'nivel_prioridad' => 1,
            'activo' => true
        ]);
        // Crear un usuario
        $user = User::factory()->create();

        // Generar un token para ese usuario
        $token = $user->createToken('TestToken')->plainTextToken;

        // Hacer una solicitud GET a una ruta protegida usando el token
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,  // Incluir el token correctamente
        ])->get('/api/user');  // Ruta protegida que requiere autenticación

        // Verificar que la respuesta sea exitosa (status 200)
        $response->assertStatus(200);

        // Verificar que el usuario devuelto en la respuesta sea el mismo
        $response->assertJson([
            'id' => $user->id,
            'name' => $user->name,
        ]);
    }

     #[Test]
    public function Sin_Acceso_Por_Falta_De_Token()
    {
        // Hacer una solicitud GET a la ruta protegida sin ningún token
        $response = $this->get('/api/user');  // Ruta protegida

        // Verificar que la respuesta sea un error de no autorizado (401)
        // Aquí estamos asegurándonos de que no se pueda acceder sin token
        $response->assertRedirect('/login');  
    }
    #[Test]
    public function Sin_Acceso_Por_Token_Falso()
    {
        // Generar un token inválido
        $invalidToken = 'invalidToken123';

        // Hacer una solicitud GET a la ruta protegida con un token inválido
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $invalidToken,  // Usar un token inválido
        ])->get('/api/user');

        // Verificar que la respuesta sea un error de no autorizado (401)
        $response->assertRedirect('/login'); 
    }
}
