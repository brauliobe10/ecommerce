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
        'estado'
    ];

    public function productos() : BelongsToMany
    {
        return $this->belongsToMany(Producto::class); // relacion muchos a muchos
    }
}
