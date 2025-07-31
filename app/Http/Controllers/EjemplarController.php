<?php

namespace App\Http\Controllers;

use App\Models\Ejemplar;
use Illuminate\Http\Request;


class EjemplarController extends Controller
{
    public function disponibles($libro)
{
    $ejemplares = Ejemplar::where('libro_id', $libro)
        ->where('disponible', true)
        ->with('libro')
        ->get();

    return response()->json($ejemplares);
}

}
