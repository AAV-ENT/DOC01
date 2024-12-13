<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Rule;

class StoreAppointmentsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'userId' => ['required', 'integer'],
            'userType' => ['required', Rule::in(['client'])],
            'serviceId' => ['required', 'integer', 'exists:services,id'], // Validate as array of existing services
            'doctorId' => ['integer', 'required', 'exists:doctors,id'], // Validate as array of existing doctors
            'locationId' => ['integer', 'required', 'exists:locations,id'],
            'appointmentType' => ['required', Rule::in(['T', 'S', 'U', 'Sub'])], // T = Sending Ticket, S = Simple, U = Urgent, Sub = Subscription
            'name' => ['required', 'string'],
            'email' => ['required', 'string'],
            'phone' => ['required', 'string'],
            // 'ssn' => ['required', 'digits:13'],
            'date' => ['required', 'date'],
            'hour' => ['required', 'integer'],
            'minute' => ['required', 'integer']
        ];
    }

    protected function prepareForValidation() {
        $this->merge([
            'appointment_type' => $this->appointmentType,
            'user_id' => $this->userId,
            'service_id' => $this->serviceId,
            'doctor_id' => $this->doctorId,
            'location_id' => $this->locationId,
            'user_type' => $this->userType
        ]);
    }
}
