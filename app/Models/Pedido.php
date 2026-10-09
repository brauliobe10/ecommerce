<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pedido extends Model
{
    public const PAGINATION = 10;

    public const ESTADO_PENDIENTE = 'pendiente';

    public const ESTADO_CONFIRMADO = 'confirmado';

    public const ESTADO_CANCELADO = 'cancelado';

    protected $fillable = [
        'cliente_id',
        'venta_id',
        'nombre_cliente',
        'telefono',
        'email',
        'direccion',
        'notas',
        'total',
        'estado',
    ];

    protected function casts(): array
    {
        return [
            'total' => 'decimal:2',
        ];
    }

    /**
     * @return BelongsTo<Cliente, $this>
     */
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    /**
     * @return BelongsTo<Venta, $this>
     */
    public function venta(): BelongsTo
    {
        return $this->belongsTo(Venta::class);
    }

    /**
     * @return HasMany<PedidoDetalle, $this>
     */
    public function detallePedidos(): HasMany
    {
        return $this->hasMany(PedidoDetalle::class);
    }
}
