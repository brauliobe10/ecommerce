<?php

namespace App\Policies;

use App\Models\Pedido;
use App\Models\User;

class PedidoPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isStaff();
    }

    public function view(User $user, Pedido $pedido): bool
    {
        return $user->isStaff() || $pedido->perteneceA($user);
    }

    public function cancel(User $user, Pedido $pedido): bool
    {
        if ($user->isStaff()) {
            return true;
        }

        return $pedido->perteneceA($user)
            && $pedido->estado === Pedido::ESTADO_PENDIENTE;
    }

    public function delete(User $user, Pedido $pedido): bool
    {
        return $user->isStaff();
    }
}
