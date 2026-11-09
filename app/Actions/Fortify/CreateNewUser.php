<?php

namespace App\Actions\Fortify;

use App\Concerns\PasswordValidationRules;
use App\Concerns\ProfileValidationRules;
use App\Models\Cliente;
use App\Models\Pedido;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules, ProfileValidationRules {
        ProfileValidationRules::messages insteadof PasswordValidationRules;
    }

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            ...$this->profileRules(),
            'telefono' => ['nullable', 'string', 'max:20'],
            'password' => $this->passwordRules(),
        ])->validate();

        return DB::transaction(function () use ($input) {
            $email = Str::lower(trim((string) $input['email']));
            $telefono = filled($input['telefono'] ?? null) ? trim((string) $input['telefono']) : null;

            $user = User::create([
                'name' => $input['name'],
                'email' => $email,
                'password' => $input['password'],
                'role' => User::ROLE_CLIENTE,
                'email_verified_at' => now(),
            ]);

            $cliente = Cliente::query()
                ->whereRaw('LOWER(email) = ?', [$email])
                ->first();

            if ($cliente !== null) {
                $cliente->update([
                    'user_id' => $user->id,
                    'telefono' => $cliente->telefono ?: $telefono,
                ]);
            } else {
                $cliente = Cliente::create([
                    'user_id' => $user->id,
                    'nombre' => $input['name'],
                    'email' => $email,
                    'telefono' => $telefono,
                ]);
            }

            // Vincula las compras realizadas como invitado con el mismo correo.
            Pedido::query()
                ->whereRaw('LOWER(email) = ?', [$email])
                ->whereNull('cliente_id')
                ->update(['cliente_id' => $cliente->id]);

            return $user;
        });
    }
}
