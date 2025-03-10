<?php

namespace App\Filters\V1;

use Illuminate\Http\Request;
use App\Filters\APIFilters;

class DoctorFilter extends APIFilters {
    protected $safeParms = [
        'location_id' => ['eq']
    ];

    protected $columnMap = [];

    protected $operatorMap = [
        "eq" => "=",
        "lt" => "<",
        "lte" => "<=",
        "gt" => ">",
        "gte" => ">="
    ];
}