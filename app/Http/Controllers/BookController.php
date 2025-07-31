<?php

namespace App\Http\Controllers;

//1. Se importa el servicio que contiene la lógica del negocio
use App\Services\BookService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Libro;

class BookController extends Controller
{
    //Inyección del servicio en el constructor
    protected $bookService;

    public function __construct(BookService $bookService)
    {
        //2. Laravel inyecta automáticamente la instancia del BookService
        $this->bookService = $bookService;
    }

    /**
     * Obtener los libros más recientes
     * - El controlador NO accede directamente al modelo Libro
     * - Llama al servicio, que se encarga de delegar al repositorio
     */
    public function getRecentBooks(): JsonResponse
    {
        $books = $this->bookService->getRecentBooks(); //Lógica en el servicio → repositorio
        return response()->json($books); //Respuesta JSON con los datos obtenidos
    }

    /**
     * Obtener libros recomendados
     * - IDs recomendados definidos dentro del servicio
     * - El controlador no sabe de la lógica de selección
     */
    public function getRecommendedBooks(): JsonResponse
    {
        $books = $this->bookService->getRecommendedBooks(); //Llama al servicio → al repositorio
        return response()->json($books); //Retorna los libros seleccionados
    }

    public function buscarLibros(Request $request): JsonResponse
    {
        $titulo = $request->input('titulo');
        $categoria = $request->input('categoria');

        if (!$titulo && !$categoria) {
            return response()->json(['error' => 'Debe ingresar título o categoría'], 400);
        }

        $libros = $this->bookService->buscarLibros($titulo, $categoria);
        return response()->json($libros);
    }
    public function show($id)
    {
        $libro = Libro::with('categoria')->findOrFail($id);
        return response()->json($libro);
    }

   
}
