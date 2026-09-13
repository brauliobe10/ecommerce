<?php

namespace App\Services\Cliente;

use App\Models\Cliente;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as PaginationLengthAwarePaginator;

class ClienteService
{
    /**
     * @param  array<string, mixed>  $filters
     * @return PaginationLengthAwarePaginator<int, Cliente>
     */
    public function getAll(array $filters = []): PaginationLengthAwarePaginator
    {
        $query = Cliente::query()->withCount('ventas');

        if (isset($filters['search']) && is_string($filters['search']) && $filters['search'] !== '') {
            $search = '%'.addcslashes(mb_strtolower(trim($filters['search'])), '%_').'%';
            $query->where(fn ($q) => $q
                ->whereRaw('LOWER(nombre) LIKE ?', [$search])
                ->orWhereRaw('LOWER(email) LIKE ?', [$search])
                ->orWhereRaw('LOWER(telefono) LIKE ?', [$search]));
        }

        return $query->latest()->paginate(Cliente::PAGINATION);
    }

    public function find(int $id): Cliente
    {
        return Cliente::findOrFail($id);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function store(array $data): Cliente
    {
        return Cliente::create($data);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function update(int $id, array $data): Cliente
    {
        $cliente = $this->find($id);
        $cliente->update($data);

        return $cliente;
    }

    public function destroy(int $id): Cliente
    {
        $cliente = $this->find($id);
        $cliente->delete();

        return $cliente;
    }
}
