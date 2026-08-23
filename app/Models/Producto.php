<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $fillable = [
        'name',
        'codigo',
        'descripcion',
        'precio',
        'stock',
        'imagen',
        'activo'
    ];
}
