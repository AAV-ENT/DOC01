<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServicesResource extends JsonResource
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
            'name' => $this->name,
            'duration' => $this->duration,
            'price' => $this->price,
            'doctor' => DoctorResource::collection($this->whenLoaded('doctor')),
            'location' => LocationResource::collection($this->location ?? [])
        ];
    }
}
