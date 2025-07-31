<?php
// app/Http/Controllers/AdminController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Libro;
use App\Models\Categoria;
use App\Models\Alquiler;
use App\Models\Comentario;
use App\Models\Ejemplar;
use App\Models\Sancion;

class AdminController extends Controller
{
    // -- Obtener todos --
    public function getUsers()       { return User::all(); }
    public function getLibros()      { return Libro::all(); }
    public function getCategorias()  { return Categoria::all(); }
    public function getAlquileres()  { return Alquiler::all(); }
    public function getComentarios() { return Comentario::all(); }
    public function getEjemplares()  { return Ejemplar::all(); }
    public function getSanciones()   { return Sancion::all(); }

    // -- Crear nuevos --
    public function storeUser(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'telefono' => 'nullable|string|max:20',
            'direccion'=> 'nullable|string|max:255',
            'activo'   => 'boolean',
            'rol_id'   => 'integer|exists:roles,id',
        ]);
        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);
        return response()->json($user, 201);
    }

    public function storeLibro(Request $request)
    {
        $data = $request->validate([
            'titulo'            => 'required|string|max:255',
            'autor'             => 'required|string|max:255',
            'descripcion'       => 'nullable|string',
            'anio_publicacion'  => 'required|integer',
            'isbn'              => 'nullable|string|max:50',
            'categoria_id'      => 'required|integer|exists:categorias,id',
        ]);
        $libro = Libro::create($data);
        return response()->json($libro, 201);
    }

    public function storeCategoria(Request $request)
    {
        $data = $request->validate([
            'nombre_cat'      => 'required|string|max:255',
            'descripcion_cat' => 'nullable|string',
        ]);
        $cat = Categoria::create($data);
        return response()->json($cat, 201);
    }

    public function storeAlquiler(Request $request)
    {
        $data = $request->validate([
            'user_id'         => 'required|integer|exists:users,id',
            'libro_id'        => 'required|integer|exists:libros,id',
            'fecha_alquiler'  => 'required|date',
            'fecha_devolucion'=> 'nullable|date',
            'devuelto'        => 'boolean',
        ]);
        $alq = Alquiler::create($data);
        return response()->json($alq, 201);
    }

    public function storeComentario(Request $request)
    {
        $data = $request->validate([
            'user_id'     => 'required|integer|exists:users,id',
            'libro_id'    => 'required|integer|exists:libros,id',
            'contenido'   => 'required|string',
            'calificacion'=> 'required|integer|min:1|max:5',
        ]);
        $com = Comentario::create($data);
        return response()->json($com, 201);
    }

    public function storeEjemplar(Request $request)
    {
        $data = $request->validate([
            'libro_id'         => 'required|integer|exists:libros,id',
            'ubicacion_fisica' => 'required|string|max:255',
            'disponible'       => 'boolean',
            'nota'             => 'sometimes|string',
        ]);
        $ej = Ejemplar::create($data);
        return response()->json($ej, 201);
    }

    public function storeSancion(Request $request)
    {
        $data = $request->validate([
            'user_id'       => 'required|integer|exists:users,id',
            'motivo'        => 'required|string',
            'fecha_inicio'  => 'required|date',
            'fecha_fin'     => 'nullable|date',
            'estado'        => 'required|string',
            'monto_sancion' => 'required|numeric',
        ]);
        $san = Sancion::create($data);
        return response()->json($san, 201);
    }

    // Actualizar usuario
public function updateUser(Request $request, $id)
{
    \Log::info('Datos recibidos para updateUser:', $request->all());
    $user = User::findOrFail($id);

    $data = $request->validate([
        'name' => 'sometimes|string|max:255',
        'email' => 'sometimes|email|unique:users,email,' . $id,
        'telefono' => 'sometimes|string|max:20',
        'direccion' => 'sometimes|string|max:255',
        'activo' => 'sometimes|boolean', // solo validamos que venga, lo convertimos abajo
        'rol_id' => 'sometimes|integer|exists:roles,id',
    ]);

    // 🛠 Convertimos "true"/"false" a booleano real
    if ($request->has('activo')) {
        $data['activo'] = filter_var($request->activo, FILTER_VALIDATE_BOOLEAN);
    }

    $user->update($data);
    \Log::info('Usuario actualizado:', $user->toArray());
    return response()->json($user);
}

    // Eliminar usuario
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(['message' => 'Usuario eliminado']);
    }

    // Actualizar libro
    public function updateLibro(Request $request, $id)
    {
        $libro = Libro::findOrFail($id);
        $data = $request->validate([
            'titulo' => 'sometimes|string|max:255',
            'autor' => 'sometimes|string|max:255',
            'descripcion' => 'sometimes|string',
            'anio_publicacion' => 'sometimes|integer',
            'isbn' => 'sometimes|string|max:50',
            'categoria_id' => 'sometimes|integer|exists:categorias,id',
            // demás campos...
        ]);
        $libro->update($data);
        return response()->json($libro);
    }

    // Eliminar libro
    public function deleteLibro($id)
    {
        $libro = Libro::findOrFail($id);
        $libro->delete();
        return response()->json(['message' => 'Libro eliminado']);
    }

    // Actualizar categoría
    public function updateCategoria(Request $request, $id)
    {
        $categoria = Categoria::findOrFail($id);
        $data = $request->validate([
            'nombre_cat' => 'sometimes|string|max:255',
            'descripcion_cat' => 'sometimes|string',
        ]);
        $categoria->update($data);
        return response()->json($categoria);
    }

    // Eliminar categoría
    public function deleteCategoria($id)
    {
        $categoria = Categoria::findOrFail($id);
        $categoria->delete();
        return response()->json(['message' => 'Categoría eliminada']);
    }

    public function updateAlquiler(Request $request, $id)
{
    $alquiler = Alquiler::findOrFail($id);
    $data = $request->validate([
        'user_id' => 'sometimes|integer|exists:users,id',
        'ejemplar_id' => 'sometimes|integer|exists:ejemplares,id',
        'fecha_alquiler' => 'sometimes|date',
        'fecha_devolucion' => 'sometimes|date|nullable',
        'devuelto' => 'sometimes|boolean',
    ]);

    // Convierte el valor recibido a booleano real
    if ($request->has('devuelto')) {
        $data['devuelto'] = filter_var($request->devuelto, FILTER_VALIDATE_BOOLEAN);
    }

    $alquiler->update($data);
    return response()->json($alquiler);
}


    // Eliminar alquiler
    public function deleteAlquiler($id)
    {
        $alquiler = Alquiler::findOrFail($id);
        $alquiler->delete();
        return response()->json(['message' => 'Alquiler eliminado']);
    }

    // Actualizar comentario
    public function updateComentario(Request $request, $id)
    {
        $comentario = Comentario::findOrFail($id);
        $data = $request->validate([
            'user_id' => 'sometimes|integer|exists:users,id',
            'libro_id' => 'sometimes|integer|exists:libros,id',
            'contenido' => 'sometimes|string',
            'calificacion' => 'sometimes|integer|min:1|max:5',
        ]);
        $comentario->update($data);
        return response()->json($comentario);
    }

    // Eliminar comentario
    public function deleteComentario($id)
    {
        $comentario = Comentario::findOrFail($id);
        $comentario->delete();
        return response()->json(['message' => 'Comentario eliminado']);
    }

    // Actualizar ejemplar
public function updateEjemplar(Request $request, $id)
{
    \Log::info('Request data:', $request->all());

    $ejemplar = Ejemplar::findOrFail($id);

    $data = $request->validate([
        'libro_id' => 'sometimes|integer|exists:libros,id',
        'ubicacion_fisica' => 'sometimes|string|max:255',
        // Ojo: No validar 'disponible' con boolean acá para poder hacer conversión manual
    ]);

    if ($request->has('disponible')) {
        // Convierte 'true'/'false' string a boolean real
        $data['disponible'] = filter_var($request->input('disponible'), FILTER_VALIDATE_BOOLEAN);
    }

    $ejemplar->update($data);

    return response()->json($ejemplar);
}


    // Eliminar ejemplar
    public function deleteEjemplar($id)
    {
        $ejemplar = Ejemplar::findOrFail($id);
        $ejemplar->delete();
        return response()->json(['message' => 'Ejemplar eliminado']);
    }

    // Actualizar sanción
    public function updateSancion(Request $request, $id)
    {
        $sancion = Sancion::findOrFail($id);
        $data = $request->validate([
            'user_id' => 'sometimes|integer|exists:users,id',
            'motivo' => 'sometimes|string',
            'fecha_inicio' => 'sometimes|date',
            'fecha_fin' => 'sometimes|date|nullable',
            'estado' => 'sometimes|string',
            'monto_sancion' => 'sometimes|numeric',
        ]);
        $sancion->update($data);
        return response()->json($sancion);
    }

    // Eliminar sanción
    public function deleteSancion($id)
    {
        $sancion = Sancion::findOrFail($id);
        $sancion->delete();
        return response()->json(['message' => 'Sanción eliminada']);
    }
}
