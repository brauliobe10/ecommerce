<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Categoria extends Model
{
    public const PAGINATION = 10;

    protected $fillable = [
        'nombre',
        'descripcion',
        'estado',
    ];

    /**
     * @return BelongsToMany<Producto, $this>
     */
    public function productos(): BelongsToMany
    {
        return $this->belongsToMany(
            Producto::class,       // 1. Modelo relacionado
            'categoria_producto',  // 2. Nombre de la tabla pivote
            'categoria_id',        // 3. Clave foránea de ESTE modelo en la pivote
            'producto_id'          // 4. Clave foránea del OTRO modelo en la pivote
        );
    }
}
