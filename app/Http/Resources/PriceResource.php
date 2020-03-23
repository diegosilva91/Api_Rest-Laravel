<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PriceResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'actions_id'=> $this->actions_id,
            'current_quantity' => $this->current_quantity,
            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at,
            'actions' => $this->actions,
        ];
//        return parent::toArray($request);
    }
}
