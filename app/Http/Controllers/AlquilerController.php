<?php

namespace App\Http\Controllers;

use App\Models\Alquiler;
use App\Models\Ejemplar;
use Illuminate\Http\Request;
use App\Models\Sancion;

class AlquilerController extends Controller
{
    public function store(Request $request)
{
    $user = $request->user();

    // Verificar si tiene sanción activa
    $sancionActiva = Sancion::where('user_id', $user->id)
        ->where('estado', true)
        ->whereDate('fecha_inicio', '<=', now())
        ->whereDate('fecha_fin', '>=', now())
        ->exists();

    if ($sancionActiva) {
        return response()->json(['error' => 'No puede alquilar libros porque tiene una sanción activa.'], 403);
    }

    // Validar datos
    $data = $request->validate([
        'libro_id' => 'required|integer|exists:libros,id',
        'ejemplar_id' => 'required|integer|exists:ejemplares,id',
    ]);

    $data['user_id'] = $user->id;

    // Crear alquiler
    $alquiler = Alquiler::create($data);

    // Actualizar ejemplar: marcar como no disponible
    $ejemplar = Ejemplar::find($data['ejemplar_id']);
    if ($ejemplar) {
        $ejemplar->disponible = false;
        $ejemplar->save();
    }

    return response()->json($alquiler, 201);
}




public function index(Request $request)
{
    $user = $request->user();

    if (!$user) {
        return response()->json(['error' => 'No autenticado'], 401);
    }

    // Carga los alquileres con el ejemplar y el libro relacionados
    $alquileres = Alquiler::with('ejemplar.libro')
        ->where('user_id', $user->id)
        ->orderBy('fecha_alquiler', 'desc')
        ->get();

    return response()->json($alquileres);
}


public function destroy(Request $request, $id)
{
    $user = $request->user();
    $alquiler = Alquiler::with('ejemplar')->find($id);

    if (!$alquiler) {
        return response()->json(['error' => 'Alquiler no encontrado'], 404);
    }

    $isAdmin = $user->rol_id === 3;
    $estado = strtolower($alquiler->estado); // minúsculas para comparar

    // Validaciones de permisos según estado y rol
    if (!$isAdmin) {
        // El usuario normal solo puede eliminar sus alquileres en estado 'pendiente'
        if ($alquiler->user_id !== $user->id) {
            return response()->json(['error' => 'No autorizado para eliminar este alquiler'], 403);
        }
        if ($estado !== 'pendiente') {
            return response()->json(['error' => 'Solo puede eliminar alquileres en estado pendiente'], 403);
        }
    } else {
        // Admin puede eliminar cualquier alquiler sin restricciones
    }

    // Cambiar disponibilidad del ejemplar solo si estado es pendiente o denegado
    if ($alquiler->ejemplar && in_array($estado, ['pendiente', 'denegado'])) {
        $alquiler->ejemplar->disponible = true;
        $alquiler->ejemplar->save();
    }

    // Eliminar alquiler
    $alquiler->delete();

    return response()->json(['message' => 'Alquiler eliminado correctamente']);
}




}
