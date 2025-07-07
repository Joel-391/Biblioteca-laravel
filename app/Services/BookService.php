<?php

namespace App\Services;

use App\Repositories\BookRepository;

class BookService
{
    protected $bookRepository;

    public function __construct(BookRepository $bookRepository)
    {
        //3. Inyección del repositorio en el servicio
        $this->bookRepository = $bookRepository;
    }

    /**
     * Lógica para libros recientes
     */
    public function getRecentBooks()
    {
        return $this->bookRepository->getRecentBooks(); //Delegado al repositorio
    }

    /**
     * Lógica de recomendados
     * - Aquí definimos los IDs recomendados (podría venir de otra tabla en el futuro)
     */
    public function getRecommendedBooks()
    {
        $recommendedIds = [10, 13, 14, 5, 4, 3]; //Definidos aquí, no en el controlador

        return $this->bookRepository->getBooksByIds($recommendedIds);
    }
}
