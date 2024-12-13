<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Resources\V1\DoctorResource;
use App\Http\Resources\V1\DoctorCollection;

use App\Filters\V1\DoctorFilter;

class DoctorController extends Controller
{
    public function index(Request $request) {
        $filter = new DoctorFilter();
        $queryItems = $filter->transform($request);

        $doctorQuery = Doctor::where($queryItems);

        $doctor = $doctorQuery->paginate()->appends($request->query());

        return new DoctorCollection($doctor);
    }

    public function show(Doctor $doctor) {
        return new DoctorResource($doctor);
    }
}
