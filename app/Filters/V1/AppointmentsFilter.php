<?php

namespace App\Filters\V1;

use Illuminate\Http\Request;
use App\Filters\APIFilters;

class AppointmentsFilter extends APIFilters {
    protected $safeParms = [
        'doctorId' => ['eq'],
        'locationId' => ['eq'],
        'appointmentType' => ['eq'],
        'confirmed' => ['eq'],
        'confirmationType' => ['eq'],
        'date' => ['eq', 'gt', 'gte', 'lt', 'lte'],
        'hour' => ['eq', 'gt', 'gte', 'lt', 'lte'],
        'minute' => ['eq', 'gt', 'gte', 'lt', 'lte'],
    ];

    protected $columnMap = [
        'appointmentType' => 'appointment_type',
        'confirmationType' => 'confirmation_type',
        'doctorId' => 'doctor_id',
        'locationId' => 'location_id'
    ];

    protected $operatorMap = [
        "eq" => "=",
        "lt" => "<",
        "lte" => "<=",
        "gt" => ">",
        "gte" => ">="
    ];
}