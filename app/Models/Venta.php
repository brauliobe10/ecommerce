<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Venta extends Model
{
    public const PAGINATION = 10;

    public const ESTADO_COMPLETADA = 'completada';

    public const ESTADO_ANULADA = 'anulada';

    public const METODO_EFECTIVO = 'efectivo';

    public const METODO_TARJETA = 'tarjeta';

    public const METODO_TRANSFERENCIA = 'transferencia';

    protected $fillable = [
        'cliente_id',
        'usuario_id',
        'fecha_venta',
        'total',
        'metodo_pago',
        'estado',
    ];

    protected function casts(): array
    {
        return [
            'fecha_venta' => 'datetime',
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
     * @return BelongsTo<User, $this>
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    /**
     * @return HasMany<DetalleVenta, $this>
     */
    public function detalleVentas(): HasMany
    {
        return $this->hasMany(DetalleVenta::class);
    }
}
