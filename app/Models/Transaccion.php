<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaccion extends Model
{
    protected $table = 'transacciones';

    protected $fillable = [
        'comercio_id',
        'monto',
        'cliente_nombre',
        'estado',
    ];

    // ── Semana 11 (viernes): transiciones válidas ─────────────────
    public const TRANSICIONES = [
        'Iniciada'   => ['Completada', 'Fallida'],
        'Completada' => [],
        'Fallida'    => ['Iniciada'],
    ];

    public function puedeMoverseA(string $estado): bool
    {
        return in_array($estado, self::TRANSICIONES[$this->estado] ?? [], true);
    }

    // ── Relaciones ────────────────────────────────────────────────
    public function comercio(): BelongsTo
    {
        return $this->belongsTo(Comercio::class);
    }

    public function eventos(): HasMany
    {
        return $this->hasMany(EventoTransaccion::class);
    }
}
