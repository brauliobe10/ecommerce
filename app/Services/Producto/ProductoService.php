<?php

namespace App\Services\Producto;

use App\Models\Producto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as PaginationLengthAwarePaginator;

class ProductoService
{
    /**
     * @param  array<string, mixed>  $filters
     * @return PaginationLengthAwarePaginator<int, Producto>
     */
    public function getAll(array $filters = []): PaginationLengthAwarePaginator
    {
        $query = Producto::query();

        if (isset($filters['search']) && is_string($filters['search']) && $filters['search'] !== '') {
            $search = '%'.addcslashes(mb_strtolower(trim($filters['search'])), '%_').'%';
            $query->where(fn ($q) => $q
                ->whereRaw('LOWER(nombre) LIKE ?', [$search])
                ->orWhereRaw('LOWER(codigo) LIKE ?', [$search])
                ->orWhereRaw('LOWER(descripcion) LIKE ?', [$search]));
        }

        if (! empty($filters['categoria'])) {
            $query->whereHas('categorias', fn ($q) => $q->where('categorias.id', $filters['categoria']));
        }

        if (! empty($filters['activo'])) {
            $query->where('activo', filter_var($filters['activo'], FILTER_VALIDATE_BOOLEAN));
        }

        return $query->latest()->paginate(Producto::PAGINATION);
    }

    public function find(int $id): Producto
    {
        return Producto::findOrFail($id);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function store(array $data): Producto
    {
        return Producto::create($data);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function update(int $id, array $data): Producto
    {
        $producto = $this->find($id);
        $producto->update($data);

        return $producto;
    }

    public function destroy(int $id): Producto
    {
        $producto = $this->find($id);
        $producto->delete();

        return $producto;
    }

    public function toggleStatus(Producto $producto): Producto
    {
        // Cambiar entre 'activo' e 'inactivo'
        $producto->activo = ! $producto->activo;
        $producto->save();

        return $producto;
    }
}
