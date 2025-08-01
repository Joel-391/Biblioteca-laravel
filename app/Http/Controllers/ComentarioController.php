<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comentario;
use App\Models\Sancion;
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

        // Verificar sanción activa
        $sancionActiva = Sancion::where('user_id', $user->id)
            ->where('estado', true)
            ->whereDate('fecha_inicio', '<=', now())
            ->whereDate('fecha_fin', '>=', now())
            ->exists();

        if ($sancionActiva) {
            return response()->json(['error' => 'No puede comentar porque tiene una sanción activa.'], 403);
        }

        // Continuar validación y creación del comentario...
        $data = $request->validate([
            'contenido' => 'required|string',
            'calificacion' => 'required|integer|min:1|max:5',
        ]);

        $data['user_id'] = $user->id;
        $data['libro_id'] = $libroId;

        $comentario = Comentario::create($data);

        return response()->json($comentario, 201);
    }
}
