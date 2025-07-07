<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Log;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function updateProfile(array $data)
    {
        $user = $this->userRepository->getAuthenticatedUser();

        Log::info('Usuario actual antes de actualización:', $user->toArray());

        $updatedUser = $this->userRepository->updateUser($user, $data);

        Log::info('Usuario después de actualización:', $updatedUser->toArray());

        return $updatedUser;
    }

    public function getProfileData()
    {
        $user = $this->userRepository->getAuthenticatedUser();

        return [
            'name' => $user->name,
            'telefono' => $user->telefono,
            'direccion' => $user->direccion,
        ];
    }
}
