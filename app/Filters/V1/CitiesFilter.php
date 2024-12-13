<?php

namespace App\Filters\V1;

use Illuminate\Http\Request;
use App\Filters\APIFilters;

class CitiesFilter extends APIFilters {
    protected $safeParms = [
        'county_code' => ['eq'],
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