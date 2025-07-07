<?php

namespace App\Http\Controllers;

// 1. Se importa el Form Request que valida la entrada (capa de validación)
use App\Http\Requests\UpdateProfileRequest;

// 2. Se importa el Servicio que contiene la lógica de negocio
use App\Services\UserService;

use Illuminate\Http\JsonResponse;

class ProfileController extends Controller
{
    // Inyección del servicio (se usa la capa de servicio aquí)
    protected $userService;

    public function __construct(UserService $userService)
    {
        // 3. Laravel resuelve automáticamente la instancia del servicio
        $this->userService = $userService;
    }

    /**
     * Método que obtiene datos del perfil del usuario
     * - No accede al modelo directamente
     * - Llama al método del servicio
     * - El servicio luego llama al repositorio
     */
    public function getProfile(): JsonResponse
    {
        $data = $this->userService->getProfileData(); // Lógica delegada al Service
        return response()->json($data); // Devuelve los datos como respuesta JSON
    }

    /**
     * Método para actualizar el perfil del usuario
     * - Recibe datos validados automáticamente por el Form Request
     * - Llama al servicio para procesar la actualización
     */
    public function update(UpdateProfileRequest $request): JsonResponse
    {
        // El método validated() devuelve solo los datos validados
        $updatedUser = $this->userService->updateProfile($request->validated()); // lógica delegada

        return response()->json($updatedUser); // Devuelve el usuario actualizado
    }
}
