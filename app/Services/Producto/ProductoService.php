<?php

namespace App\Services\Producto;

use Illuminate\Contracts\Pagination\LengthAwarePaginator as PaginationLengthAwarePaginator;

use App\Models\Producto;
use RecursiveArrayIterator;

class ProductoService
{
    public function getAll(array $filters = []): PaginationLengthAwarePaginator
    {
        $query = Producto::latest();

        if (!empty($filters['activo'])) {
            $query->where('activo', filter_var($filters['activo'], FILTER_VALIDATE_BOOLEAN));
        }

        return $query->paginate(Producto::PAGINATION);
    }

    public function find(int $id): Producto
    {
        return Producto::findOrFail($id);
    }

    public function store(array $data): Producto
    {
        return Producto::create($data);
    }

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
        $producto->activo = !$producto->activo;
        $producto->save();
        return $producto;
    }
}
