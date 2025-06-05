<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    use HasFactory;
    protected $table = 'roles';
    protected $fillable = ['nombre_rol', 'descripcion', 'nivel_prioridad', 'activo'];

    public function usuarios()
    {
        return $this->hasMany(User::class);
    }
}