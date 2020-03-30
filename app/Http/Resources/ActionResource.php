<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class ActionResource extends JsonResource
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
            'name'=>$this->name,
            'unique_code'=>$this->unique_code,
            'description'=>$this->description,
            'logo'=>$this->logo,
            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at,
            'price' => $this->price,
        ];
        //return parent::toArray($request);
    }
}
