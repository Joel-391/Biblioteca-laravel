<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\User;


class Sancion extends Model
{
    use HasFactory;
    
    protected $table = 'sanciones';
    protected $fillable = ['user_id', 'motivo', 'fecha_inicio', 'fecha_fin', 'estado', 'monto_sancion'];


    protected $casts = [
        'fecha_inicio' => 'datetime',
        'fecha_fin' => 'datetime',
        'estado' => 'boolean',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Verifica si la sanción ya terminó (fecha actual > fecha_fin)
     */
    public function haFinalizado()
    {
        return $this->estado === true && Carbon::now()->greaterThan($this->fecha_fin);
    }

    /**
     * Método estático para reactivar usuarios cuya sanción haya terminado.
     */
    public static function reactivarUsuarios()
    {
        $sanciones = self::where('estado', true)
            ->whereDate('fecha_fin', '<', Carbon::now())
            ->get();

        foreach ($sanciones as $sancion) {
            $sancion->estado = false;
            $sancion->save();

            $user = $sancion->usuario;
            if ($user) {
                $user->estado = true;
                $user->save();
            }
        }
    }
}