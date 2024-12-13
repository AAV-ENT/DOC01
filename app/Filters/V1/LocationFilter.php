<?php

namespace App\Filters\V1;

use Illuminate\Http\Request;
use App\Filters\APIFilters;

class LocationFilter extends APIFilters {
    protected $safeParms = [
        'id' => ['eq'],
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