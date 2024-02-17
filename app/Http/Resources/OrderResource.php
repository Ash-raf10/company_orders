<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'uuid' => $this->uuid,
            'order_number' => $this->order_number,
            'from_city' => $this->city_from,
            'to_city' => $this->city_to,
            'price' => $this->price,
            'company' => $this->company->name,
            'order_images' => OrderImageResource::collection($this->orderImages),
            'created_at' => $this->created_at->format('d-F-Y'),
            'updated_at' => $this->updated_at->format('d-F-y')
        ];
    }
}
