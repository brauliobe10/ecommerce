<?php

namespace App\Services\Categoria;

use App\Models\Categoria;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as PaginationLengthAwarePaginator;

class CategoriaService
{
    /**
     * @param  array<string, mixed>  $filters
     * @return PaginationLengthAwarePaginator<int, Categoria>
     */
    public function getAll(array $filters = []): PaginationLengthAwarePaginator
    {
        $query = Categoria::query();

        if (isset($filters['search']) && is_string($filters['search']) && $filters['search'] !== '') {
            $search = '%'.addcslashes(mb_strtolower(trim($filters['search'])), '%_').'%';
            $query->where(fn ($q) => $q
                ->whereRaw('LOWER(nombre) LIKE ?', [$search])
                ->orWhereRaw('LOWER(descripcion) LIKE ?', [$search]));
        }

        if (! empty($filters['estado'])) {
            $query->where('estado', $filters['estado']);
        }

        return $query->latest()->paginate(Categoria::PAGINATION);
    }

    public function find(int $id): Categoria
    {
        return Categoria::findOrFail($id);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function store(array $data): Categoria
    {
        return Categoria::create($data);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function update(int $id, array $data): Categoria
    {
        $categoria = $this->find($id);
        $categoria->update($data);

        return $categoria;
    }

    public function destroy(int $id): Categoria
    {
        $categoria = $this->find($id);
        $categoria->delete();

        return $categoria;
    }

    public function toggleStatus(Categoria $categoria): Categoria
    {
        // Cambiar entre 'activo' e 'inactivo'
        $categoria->estado = ($categoria->estado === 'activo') ? 'inactivo' : 'activo';
        $categoria->save();

        return $categoria;
    }
}
