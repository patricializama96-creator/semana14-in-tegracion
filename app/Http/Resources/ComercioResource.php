<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ComercioResource extends JsonResource
{
    /**
     * Semana 13 · Lab 4 y 5: contrato público del comercio.
     * Solo salen los campos que decidimos exponer.
     * Las transacciones salen solo si se cargaron con load() o with().
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre_comercio,
            'rubro' => $this->rubro,
            'transacciones' => TransaccionResource::collection(
                $this->whenLoaded('transacciones')
            ),
        ];
    }
}
