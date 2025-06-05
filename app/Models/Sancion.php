<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sancion extends Model
{
    use HasFactory;
    
    protected $table = 'sanciones';
    protected $fillable = ['user_id', 'motivo', 'fecha_inicio', 'fecha_fin', 'estado', 'monto_sancion'];

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }
}