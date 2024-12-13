<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Cities;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Resources\V1\CitiesResource;
use App\Http\Resources\V1\CitiesCollection;

use App\Filters\V1\CitiesFilter;

class CitiesController extends Controller
{
    public function index(Request $request) {
        $filter = new CitiesFilter();
        $queryItems = $filter->transform($request);

        $cities = Cities::where($queryItems)->orderBy('location_name', 'asc')->get();

        return new CitiesCollection($cities);
    }

    public function show(Cities $cities, Request $request) {
        return new CitiesResource($cities);
    }
}
