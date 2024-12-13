<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentsResource extends JsonResource
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
            'createdBy' => $this->created_by,
            'doctorId' => $this->doctor_id,
            'serviceId' => $this->service_id,
            'locationId' => $this->location_id,
            'appointmentType' => $this->appointment_type,
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'ssn' => $this->ssn,
            'location' => $this->location,
            'city' => $this->city,
            'country' => $this->country,
            'confirmed' => $this->confirmed,
            'confirmationType' => $this->confirmation_type,
            'date' => $this->date,
            'hour' => $this->hour,
            'minute' => $this->minute,
        ];
    }
}
