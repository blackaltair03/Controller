<?php

// app/Http/Resources/BrazaleteResource.php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BrazaleteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'qr_code' => $this->qr_code,
            'fecha_ingreso' => $this->fecha_in->format('Y-m-d H:i:s'),
            'fecha_salida' => $this->fecha_out->format('Y-m-d H:i:s'),
            'reingresos' => $this->contador_reingresos,
            'estatus' => $this->whenLoaded('estatus', function () {
                return [
                    'codigo' => $this->estatus->codigo,
                    'nombre' => $this->estatus->nombre,
                ];
            }),
            'creado_en' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
