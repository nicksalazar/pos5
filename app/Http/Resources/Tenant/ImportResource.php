<?php

namespace App\Http\Resources\Tenant;

use Illuminate\Http\Resources\Json\JsonResource;

class ImportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        /** @var \App\Models\Tenant\Person $this */
        return $this->getCollectionData();
        /** Pasado al modelo  */
        return [
            'id' => $this->id,
            'numeroImportacion' => $this->numeroImportacion,
            'tipoTransporte'=> $this->tipoTransporte,
            'fechaEmbarque'=> $this->fechaEmbarque,
            'fechaLlegada'=>$this->fechaLlegada,
            'estado' => $this->estado,

        ];
    }
}
