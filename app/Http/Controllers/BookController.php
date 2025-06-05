<?php

namespace App\Http\Controllers;

use App\Models\Libro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    public function getRecentBooks()
    {
        // Obtener los 3 libros más recientes
        $books = Libro::latest()  // Ordena por fecha de creación descendente
                        ->take(3)  // Limita la cantidad a 3 libros
                        ->get();

        return response()->json($books);
    }
    
    public function getRecommendedBooks()
    {
    // Definir los libros recomendados directamente en el backend (puedes poner los IDs específicos que quieras)
      $recommendedIds = [10, 13, 14, 5, 4, 3];  // Aquí defines los libros recomendados manualmente

    // Obtener los libros recomendados de la base de datos
      $books = Libro::whereIn('id', $recommendedIds)->get();

      return response()->json($books);
    }

}
