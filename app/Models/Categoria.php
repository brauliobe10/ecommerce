<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    public const PAGINATION = 10 ;

    protected $fillable = [
        'nombre',
        'descripcion',
        'estado'
    ];
}
