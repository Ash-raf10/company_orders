<?php

namespace App\Http\Resources;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'company_code' => $this->company_code,
            'commercial_record_number' => $this->commercial_record_number,
            'commercial_record_image' =>
            $this->commercial_record_image ? Storage::url($this->commercial_record_image) : "",
            'logo' =>
            $this->logo ? Storage::url($this->logo) : "",
            'country' => $this->country->name,
            'created_at' => $this->created_at->format('d-F-Y'),
            'updated_at' => $this->updated_at->format('d-F-y')
        ];
    }
}
