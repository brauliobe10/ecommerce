<?php

namespace App\Policies;

use App\Models\Producto;
use App\Models\User;

class ProductoPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isStaff();
    }

    public function view(User $user, Producto $producto): bool
    {
        return $user->isStaff();
    }

    public function create(User $user): bool
    {
        return $user->isStaff();
    }

    public function update(User $user, Producto $producto): bool
    {
        return $user->isStaff();
    }

    public function delete(User $user, Producto $producto): bool
    {
        return $user->isStaff();
    }
}
