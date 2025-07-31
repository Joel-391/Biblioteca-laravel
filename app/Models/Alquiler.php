<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alquiler extends Model
{
    use HasFactory;
    protected $table = 'alquileres';
    protected $fillable = ['user_id', 'ejemplar_id', 'fecha_alquiler', 'fecha_devolucion', 'devuelto', 'estado'];

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }

    public function ejemplar()
{
    return $this->belongsTo(Ejemplar::class);
}

}