<?php

namespace App\Services\Categoria;

use App\Models\Categoria;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as PaginationLengthAwarePaginator;


class CategoriaService
{

    public function getAll(array $filters = []) : PaginationLengthAwarePaginator
    {
        $query = Categoria::latest();

        if(!empty($filters['estado'])){
            $query->where('estado' , $filters['estado']);
        }

        return $query->paginate(Categoria::PAGINATION);
    }

    public function find(int $id) : Categoria
    {
        return Categoria::findOrFail($id);
    }

    public function create(array $data): Categoria
    {
        return Categoria::create($data);
    }

    public function update(int $id , array $data): Categoria
    {   
        $categoria = $this->find($id);
        $categoria->update($data);
        return $categoria;
    }

    public function destroy(int $id) : Categoria
    {
        $categoria = $this->find($id);
        $categoria->delete();
        return $categoria;
    }

    public function toggleStatus(Categoria $cat): Categoria
    {
        // Cambiar entre 'activo' e 'inactivo'
        $cat->estado = ($cat->estado === 'activo') ? 'inactivo' : 'activo';
        $cat->save();
        return $cat;
    }
}
