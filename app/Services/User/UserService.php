<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as PaginationLengthAwarePaginator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class UserService
{
    /**
     * @param  array<string, mixed>  $filters
     * @return PaginationLengthAwarePaginator<int, User>
     */
    public function getAll(array $filters = []): PaginationLengthAwarePaginator
    {
        $query = User::query()
            ->whereIn('role', [User::ROLE_ADMIN, User::ROLE_VENDEDOR]);

        if (isset($filters['search']) && is_string($filters['search']) && $filters['search'] !== '') {
            $search = '%'.addcslashes(mb_strtolower(trim($filters['search'])), '%_').'%';
            $query->where(fn ($q) => $q
                ->whereRaw('LOWER(name) LIKE ?', [$search])
                ->orWhereRaw('LOWER(email) LIKE ?', [$search]));
        }

        return $query->latest()->paginate(User::PAGINATION);
    }

    public function find(int $id): User
    {
        return User::findOrFail($id);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function store(array $data): User
    {
        return User::create([
            'name' => $data['name'],
            'email' => Str::lower(trim((string) $data['email'])),
            'password' => $data['password'],
            'role' => $data['role'] ?? User::ROLE_VENDEDOR,
            'email_verified_at' => now(),
        ]);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function update(int $id, array $data): User
    {
        $user = $this->find($id);

        if (isset($data['email'])) {
            $data['email'] = Str::lower(trim((string) $data['email']));
        }

        $nuevoRol = $data['role'] ?? $user->role;

        if ($user->isAdmin() && $nuevoRol !== User::ROLE_ADMIN && $this->cantidadAdmins() <= 1) {
            throw ValidationException::withMessages([
                'role' => 'No puedes quitar el rol al último administrador.',
            ]);
        }

        $user->update($data);

        return $user;
    }

    public function destroy(int $id): User
    {
        $user = $this->find($id);

        if ($user->id === auth()->id()) {
            throw ValidationException::withMessages([
                'usuario' => 'No puedes eliminar tu propia cuenta desde este módulo.',
            ]);
        }

        if ($user->isAdmin() && $this->cantidadAdmins() <= 1) {
            throw ValidationException::withMessages([
                'usuario' => 'No puedes eliminar al último administrador.',
            ]);
        }

        if ($user->ventas()->exists()) {
            throw ValidationException::withMessages([
                'usuario' => 'No puedes eliminar un usuario con ventas registradas.',
            ]);
        }

        $user->delete();

        return $user;
    }

    private function cantidadAdmins(): int
    {
        return User::query()->where('role', User::ROLE_ADMIN)->count();
    }
}
