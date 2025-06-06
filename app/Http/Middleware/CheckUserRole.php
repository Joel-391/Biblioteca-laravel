<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserRole
{
    /**
     * Maneja una solicitud entrante.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Verificar si el usuario está autenticado
        if (Auth::check()) {
            // Obtener el rol del usuario
            $roleId = Auth::user()->rol_id;

            // Si el rol es 2, redirigir al login
            if ($roleId == 2) {
                return redirect()->route('login')->with('error', 'No tienes acceso a esta área.');
            }
        }

        return $next($request);
    }
}
