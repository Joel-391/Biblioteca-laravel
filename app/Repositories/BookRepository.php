<?php

namespace App\Repositories;

use App\Models\Libro;

class BookRepository
{
    /**
     * Consulta los libros más recientes
     */
    public function getRecentBooks(int $limit = 3)
    {
        return Libro::latest()->take($limit)->get(); //ORM accede directamente a la BD
    }

    /**
     * Consulta libros por un arreglo de IDs
     */
    public function getBooksByIds(array $ids)
    {
        return Libro::whereIn('id', $ids)->get(); //ORM también
    }
}
