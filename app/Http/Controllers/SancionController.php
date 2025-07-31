<?php

namespace App\Http\Controllers;

use App\Models\Sancion;
use App\Models\User;
use Illuminate\Http\Request;

class SancionController extends Controller
{
    public function index($userId)
    {
        return Sancion::where('user_id', $userId)->orderByDesc('created_at')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'motivo' => 'required|string',
            'fecha_fin' => 'nullable|date',
            'monto_sancion' => 'nullable|numeric',
        ]);

        return Sancion::create([
            'user_id' => $request->user_id,
            'motivo' => $request->motivo,
            'fecha_fin' => $request->fecha_fin,
            'monto_sancion' => $request->monto_sancion,
        ]);
    }

    public function delete($id)
    {
        return Sancion::destroy($id);
    }
}
