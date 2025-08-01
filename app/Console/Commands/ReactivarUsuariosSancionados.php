<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Sancion;
use App\Models\User;
use Carbon\Carbon;

class ReactivarUsuariosSancionados extends Command
{
    protected $signature = 'usuarios:reactivar';
    protected $description = 'Reactivar usuarios cuyas sanciones han expirado y actualizar estado de sanciones';

    public function handle()
    {
        $hoy = Carbon::now();

        // Paso 1: Marcar sanciones vencidas como inactivas
        $sancionesExpiradas = Sancion::where('estado', true)
            ->where('fecha_fin', '<=', $hoy)
            ->get();

        foreach ($sancionesExpiradas as $sancion) {
            $sancion->estado = false;
            $sancion->save();
            $this->info("Sanción ID {$sancion->id} marcada como inactiva.");
        }

        // Paso 2: Reactivar usuarios sin sanciones activas
        $usuarios = User::where('activo', false)->get();

        foreach ($usuarios as $usuario) {
            $sancionesActivas = $usuario->sanciones()
                ->where('estado', true)
                ->count();

            if ($sancionesActivas === 0) {
                $usuario->activo = true;
                $usuario->save();
                $this->info("Usuario ID {$usuario->id} reactivado.");
            }
        }

        return 0;
    }
}
