<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Location;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Resources\V1\LocationResource;
use App\Http\Resources\V1\LocationCollection;

use App\Filters\V1\LocationFilter;

class LocationController extends Controller
{
    public function index(Request $request) {
        $filter = new LocationFilter();
        $queryItems = $filter->transform($request);

        $locationQuery = Location::where($queryItems);

        $location = $locationQuery->paginate()->appends($request->query());

        return new LocationCollection($location);
    }

    public function show(Location $location) {
        return new LocationResource($location);
    }

    // public function index(Request $request) {
    //     $user = $request->user();

    //     return new LocationCollection(Location::where('user_id', $user->id)->get());
    // }

    // public function show(Location $location, Request $request) {
    //     $user = $request->user();

    //     if ($location->user_id === $user->id) {
    //         return new LocationResource($location);
    //     }

    //     // Return a 404 response if the location does not belong to the user
    //     return response()->json(['message' => 'Not authorized'], 404);
    // }
}
