<?php

namespace App\Filters\V1;

use Illuminate\Http\Request;
use App\Filters\APIFilters;

class ServicesFilter extends APIFilters {
    protected $safeParms = [
        'name' => ['eq'],
        'duration' => ['eq', 'gt', 'gte', 'lt', 'lte'],
        'price' => ['eq', 'gt', 'gte', 'lt', 'lte']
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