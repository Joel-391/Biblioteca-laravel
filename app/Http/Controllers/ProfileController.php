<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function getProfile(Request $request)
    {
        // Obtén el usuario autenticado
        $user = Auth::user();

        // Devolver solo los datos necesarios
        return response()->json([
            'name' => $user->name,
            'telefono' => $user->telefono,
            'direccion' => $user->direccion,
        ]);
    }

    // Método para actualizar el perfil del usuario

// Método para actualizar el perfil del usuario
public function update(Request $request)
{
    // Validación de los datos enviados
    $request->validate([
        'name' => 'required|string|max:255',
        'telefono' => 'nullable|string|max:10',
        'direccion' => 'nullable|string',
    ]);

    // Obtener el usuario autenticado
    $user = Auth::user();

    // Verificar que estamos obteniendo el usuario correcto
    \Log::info('Usuario actual antes de actualización:', $user->toArray());

    // Actualizar los datos
    $user->name = $request->name;
    $user->telefono = $request->telefono;
    $user->direccion = $request->direccion;
    $user->save();

    // Verificar si se guardó correctamente
    \Log::info('Usuario después de actualización:', $user->toArray());

    // Responder con éxito
    return response()->json($user);
}



}
