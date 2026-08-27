<?php

use App\Models\Producto;

class ProductoService {
    public function getAll() : Producto
    {
        return Producto::latest();
    }

    public function find(int $id) : Producto 
    {
        return Producto::findOrFail($id);
    }

    public function store(array $data) : Producto
    {
        return Producto::create($data);
    }

    public function update(int $id ,array $data) : Producto
    {
        $producto = $this->find($id);
        $producto->update($data);
        return $producto;
    }

    public function destroy(int $id) : Producto
    {
        $producto = $this->find($id);
        $producto->delete();
        return $producto;
    }

    public function toggleStatus(Producto $producto): Producto
    {
        // Cambiar entre 'activo' e 'inactivo'
        $producto->estado = ($producto->estado === 'activo') ? 'inactivo' : 'activo';
        $producto->save();
        return $producto;
    }



}
