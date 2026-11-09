<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Venta;

class VentaPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isStaff();
    }

    public function view(User $user, Venta $venta): bool
    {
        return $user->isStaff();
    }

    public function create(User $user): bool
    {
        return $user->isStaff();
    }

    public function update(User $user, Venta $venta): bool
    {
        return $user->isStaff();
    }

    public function delete(User $user, Venta $venta): bool
    {
        return $user->isStaff();
    }
}
