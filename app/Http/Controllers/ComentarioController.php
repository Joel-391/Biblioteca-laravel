<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comentario;

class ComentarioController extends Controller
{
    // Obtener comentarios de un libro
    public function index($libroId)
    {
        $comentarios = Comentario::with('user')
            ->where('libro_id', $libroId)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($comentarios);
    }

    // Guardar un nuevo comentario
    public function store(Request $request, $libroId)
    {
        $user = $request->user();

        if (!$user || !$user->activo) {
            return response()->json([
                'message' => 'Tu cuenta ha sido desactivada. No puedes comentar.'
            ], 403);
        }

        $validated = $request->validate([
            'contenido' => 'required|string',
            'calificacion' => 'required|integer|min:0|max:5',
        ]);

        $comentario = Comentario::create([
            'user_id' => $user->id,
            'libro_id' => $libroId,
            'contenido' => $validated['contenido'],
            'calificacion' => $validated['calificacion'],
        ]);

        return response()->json($comentario, 201);
    }
}
