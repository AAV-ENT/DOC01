<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Appointments;
use App\Http\Requests\V1\StoreAppointmentsRequest;
use App\Http\Requests\UpdateAppointmentsRequest;

use App\Http\Controllers\Controller;

use App\Filters\V1\AppointmentsFilter;

use App\Http\Resources\V1\AppointmentsResource;
use App\Http\Resources\V1\AppointmentsCollection;

use Illuminate\Http\Request;

class AppointmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new AppointmentsFilter();
        $queryItems = $filter->transform($request);

        $appointments = appointments::where($queryItems);

        return new AppointmentsCollection($appointments->get());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAppointmentsRequest $request)
    {
        // Create a new appointment
        $appointment = Appointments::create($request->all());

        // Attach doctors to the appointment
        if ($request->has('doctorId')) {
            $appointment->doctor()->attach($request->doctorIds);
        }

        // Attach services to the appointment
        if ($request->has('serviceId')) {
            $appointment->services()->attach($request->serviceIds);
        }

        return new AppointmentsResource($appointment);
    }


    /**
     * Display the specified resource.
     */
    public function show(Appointments $appointments)
    {    
        return new AppointmentsResource($appointments);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appointments $appointments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAppointmentsRequest $request, Appointments $appointments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointments $appointments)
    {
        //
    }

    public function setup(Request $request)
    {
        $serviceId = $request->query('serviceId');
        $service = Service::findOrFail($serviceId);

        $locations = $service->locations()->with('city')->get();
        $cities = $locations->groupBy('city.id');

        return response()->json([
            'cities' => $cities->map(fn($locs) => [
                'id' => $locs->first()->city->id,
                'name' => $locs->first()->city->name,
            ])->values(),
            'locations' => $locations,
            'singleCity' => $cities->count() === 1,
            'singleLocation' => $locations->count() === 1 ? $locations->first() : null,
        ]);
    }

    public function availability(Request $request)
    {
        $doctorId = $request->query('doctorId');
        // $locationId = $request->query('locationId');
        $duration = $request->query('duration');

        // $appointments = Appointment::where('location_id', $locationId)
        $appointments = Appointment::when($doctorId, fn($query) => $query->where('doctor_id', $doctorId))
            ->whereBetween('date', [now(), now()->addYear()])
            ->get();

        $openingTime = '08:00';
        $closingTime = '18:00';

        $dates = [];
        $date = now();

        while ($date->lte(now()->addYear())) {
            $dailyAppointments = $appointments->where('date', $date->toDateString());

            if ($this->isTimeAvailable($dailyAppointments, $openingTime, $closingTime, $duration)) {
                $dates[] = $date->toDateString();
            }

            $date->addDay();
        }

        return response()->json(['availableDates' => $dates]);
    }

    private function isTimeAvailable($appointments, $openingTime, $closingTime, $duration)
    {
        $availableTimeSlots = [];

        $currentSlot = $openingTime;
        while (strtotime($currentSlot) + $duration * 60 <= strtotime($closingTime)) {
            $nextSlot = date('H:i', strtotime($currentSlot) + $duration * 60);
            if (!$appointments->contains(fn($a) => $this->conflicts($a, $currentSlot, $nextSlot))) {
                $availableTimeSlots[] = $currentSlot;
            }
            $currentSlot = $nextSlot;
        }

        return !empty($availableTimeSlots);
    }

    private function conflicts($appointment, $start, $end)
    {
        $appointmentStart = "{$appointment->hour}:{$appointment->minute}";
        $appointmentEnd = date('H:i', strtotime($appointmentStart) + $appointment->service->duration * 60);
        return !($end <= $appointmentStart || $start >= $appointmentEnd);
    }
}
