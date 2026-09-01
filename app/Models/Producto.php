<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $fillable = [
        'nombre',
        'codigo',
        'descripcion',
        'precio',
        'stock',
        'imagen',
        'activo'
    ];

    public function categorias()
    {
        return $this->belongsToMany(
            Producto::class,       // 1. Modelo relacionado
            'categoria_producto',  // 2. Nombre de la tabla pivote
            'categoria_id',        // 3. Clave foránea de ESTE modelo en la pivote
            'producto_id'          // 4. Clave foránea del OTRO modelo en la pivote
        );        
    }
}
