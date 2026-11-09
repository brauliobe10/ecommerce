<?php

namespace App\Policies;

use App\Models\Cliente;
use App\Models\User;

class ClientePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isStaff();
    }

    public function view(User $user, Cliente $cliente): bool
    {
        return $user->isStaff() || $cliente->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->isStaff();
    }

    public function update(User $user, Cliente $cliente): bool
    {
        return $user->isStaff() || $cliente->user_id === $user->id;
    }

    public function delete(User $user, Cliente $cliente): bool
    {
        return $user->isStaff();
    }
}
