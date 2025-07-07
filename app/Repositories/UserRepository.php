<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function getAuthenticatedUser(): User
    {
        return auth()->user();
    }

    public function updateUser(User $user, array $data): User
    {
        $user->update($data);
        return $user;
    }
}
