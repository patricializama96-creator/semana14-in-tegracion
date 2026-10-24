<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comercio extends Model
{
    use HasFactory;

    /**
     * Semana 6 · Eloquent ORM
     * Campos que se pueden asignar de forma masiva (create()/update()).
     * Semana 12: se agrega user_id (el dueño del comercio).
     */
    protected $fillable = [
        'user_id',
        'nombre_comercio',
        'rubro',
        'telefono',
    ];

    /**
     * Un Comercio tiene muchas Transacciones.
     * Analogía: la cocina (Eloquent) sabe que "un comercio pidió muchos platillos".
     */
    public function transacciones(): HasMany
    {
        return $this->hasMany(Transaccion::class);
    }

    /**
     * Semana 12: un Comercio pertenece a un Usuario (su dueño).
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
