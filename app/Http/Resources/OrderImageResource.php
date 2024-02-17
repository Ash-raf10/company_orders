<?php

namespace App\Http\Resources;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderImageResource extends JsonResource
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
            'image_path' =>
            $this->image_path ? Storage::url($this->image_path) : "",
            'created_at' => $this->created_at->format('d-F-Y'),
            'updated_at' => $this->updated_at->format('d-F-y')
        ];
    }
}
