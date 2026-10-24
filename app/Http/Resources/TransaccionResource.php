<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransaccionResource extends JsonResource
{
    /**
     * Semana 13 · Lab 5: contrato público de la transacción.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'cliente' => $this->cliente_nombre,
            'monto' => (float) $this->monto,
            'estado' => $this->estado,
            'fecha' => $this->created_at->toIso8601String(),
        ];
    }
}
