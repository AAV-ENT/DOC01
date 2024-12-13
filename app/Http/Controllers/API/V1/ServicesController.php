<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Services;
use App\Models\Location;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Resources\V1\ServicesResource;
use App\Http\Resources\V1\ServicesCollection;

use App\Filters\V1\ServicesFilter;

class ServicesController extends Controller
{
    public function index(Request $request) {
        $filter = new ServicesFilter();
        $queryItems = $filter->transform($request);
    
        $includeDoctors = $request->query('includeDoctors');
        $includeLocation = $request->query('includeLocation');
    
        $servicesQuery = Services::where($queryItems);
    
        if ($includeDoctors) {
            $servicesQuery = $servicesQuery->with('doctor');
        }
    
        $services = $servicesQuery->paginate()->appends($request->query());
    
        if ($includeLocation) {
            $services->getCollection()->transform(function ($service) {
                $service->location = $this->getLocationsFromArray($service->location_id);
                return $service;
            });
        }
    
        return new ServicesCollection($services);
    }
    

    public function show(Services $service, Request $request) {
        $includeDoctors = $request->query('includeDoctors');
        $includeLocation = $request->query('includeLocation');
    
        if ($includeDoctors) {
            $service->loadMissing('doctor');
        }
    
        if ($includeLocation) {
            $service->location = $this->getLocationsFromArray($service->location_id);
        }
    
        return new ServicesResource($service);
    }
    

    private function getLocationsFromArray($locationIds) {
        if (is_string($locationIds)) {
            $locationIds = json_decode($locationIds, true); // Decode JSON if it's stored as a string
        }
    
        if (is_array($locationIds)) {
            return Location::whereIn('id', $locationIds)->get();
        }
    
        return [];
    }
    
}
