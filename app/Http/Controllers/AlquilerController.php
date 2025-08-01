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

        $sancionActiva = Sancion::where('user_id', $user->id)
            ->where('estado', true)
            ->whereDate('fecha_inicio', '<=', now())
            ->whereDate('fecha_fin', '>=', now())
            ->exists();

        if ($sancionActiva) {
            return response()->json(['error' => 'No puede alquilar libros porque tiene una sanción activa.'], 403);
        }

        $data = $request->validate([
            'libro_id' => 'required|integer|exists:libros,id',
            // otros campos si es necesario
        ]);

        $data['user_id'] = $user->id;
        $alquiler = Alquiler::create($data);

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



}
