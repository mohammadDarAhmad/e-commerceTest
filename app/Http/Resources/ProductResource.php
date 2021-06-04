<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'serial' => $this->serial,
            'price' => $this->price,
            'order_id' => $this->order_id,
            'orders' => new OrderCollection($this->whenLoaded('orders'))


        ];
    }
}
