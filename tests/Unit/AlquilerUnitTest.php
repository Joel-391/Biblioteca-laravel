<?php

namespace Tests\Unit;
use App\Models\Rol;
use App\Models\User;
use App\Models\Categoria;
use App\Models\Libro;
use App\Models\Alquiler;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;


class AlquilerUnitTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function puede_crear_un_alquiler_con_usuario()
    {
        // Crear una categoría
        $categoria = Categoria::create([
            'nombre_cat' => 'Ficción',
            'descripcion_cat' => 'Libros de ficción y novelas'
        ]);

        // Crear un rol en la tabla roles
        $rol = Rol::create([
            'nombre_rol' => 'Usuario',
            'descripcion' => 'Rol estándar para usuarios',
            'nivel_prioridad' => 1,
            'activo' => true
        ]);

        // Crear un usuario
        $user = User::create([
            'name' => 'Carlos Johan',
            'email' => 'carlos@example.com',
            'password' => bcrypt('password123'),
            'rol_id' => 1, // Asegúrate de que el rol_id exista
        ]);

        // Crear un libro asociado a la categoría
        $libro = Libro::create([
            'titulo' => 'El Quijote',
            'autor' => 'Miguel de Cervantes',
            'descripcion' => 'Un clásico de la literatura española que narra las aventuras de un caballero y su fiel escudero.',
            'anio_publicacion' => 1605,
            'isbn' => '978-3-16-148410-0',
            'categoria_id' => $categoria->id
        ]);

        // Crear un alquiler para ese usuario y libro
        $alquilerData = [
            'user_id' => $user->id,
            'libro_id' => $libro->id,
            'fecha_alquiler' => now(),
            'fecha_devolucion' => now()->addDays(7),
            'devuelto' => false,
        ];

        // Crear el alquiler
        $alquiler = Alquiler::create($alquilerData);

        // Verificar que el alquiler se guardó correctamente en la base de datos
        $this->assertDatabaseHas('alquileres', $alquilerData);
    }
}
