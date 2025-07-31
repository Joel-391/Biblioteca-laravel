<?php

namespace App\Http\Controllers;

use App\Models\Alquiler;
use App\Models\Ejemplar;
use Illuminate\Http\Request;

class AlquilerController extends Controller
{
    public function store(Request $request)
{
    $request->validate([
        'ejemplar_id' => 'required|exists:ejemplares,id',
    ]);

    $user = $request->user(); // Usuario autenticado

    if (!$user) {
        return response()->json(['error' => 'No autenticado'], 401);
    }

    $ejemplar = Ejemplar::findOrFail($request->ejemplar_id);

    if (!$ejemplar->disponible) {
        return response()->json(['error' => 'Ejemplar no disponible'], 422);
    }

    $alquiler = Alquiler::create([
        'user_id' => $user->id,
        'ejemplar_id' => $request->ejemplar_id,
        'estado' => 'Pendiente',
    ]);

    $ejemplar->disponible = false;
    $ejemplar->save();

    return response()->json(['message' => 'Alquiler registrado con éxito', 'alquiler' => $alquiler]);
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



}
