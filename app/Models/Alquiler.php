<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alquiler extends Model
{
    use HasFactory;
    protected $table = 'alquileres';
    protected $fillable = ['user_id', 'libro_id', 'fecha_alquiler', 'fecha_devolucion', 'devuelto'];

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }

    public function libro()
    {
        return $this->belongsTo(Libro::class);
    }
}