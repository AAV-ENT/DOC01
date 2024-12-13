<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Counties;
use App\Models\Cities;
use App\Models\Doctor;
use App\Models\Services;

use App\Http\Requests\StorelocationRequest;
use App\Http\Requests\UpdatelocationRequest;

use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $user = $request->user();
        $counties = Counties::orderBy('county_name', 'asc')->get();
        $cities = Cities::get();

        return view('management.location', compact('user', 'counties', 'cities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'name' => ['required', 'min:3'],
            'address' => ['required', 'min:5'],
            'city' => ['required', 'numeric'],
            'state' => ['required', 'numeric']
        ]);

        $location = new Location();

        $location->user_id = $request->user()->id;
        $location->name = $fields['name'];
        $location->address = $fields['address'];
        $location->city = $fields['city'];
        $location->state = $fields['state'];

        $startingTime = [];
        $endingTime = [];
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

        foreach ($days as $day) {
            $workingDayCheck = $request->input("workingDay_$day");
            $start = $request->input("startingTime_$day");
            $end = $request->input("endingTime_$day");

            if ($start && $end) {
                $startingTime[] = [
                    'day' => $day,
                    'start_time' => $start,
                ];
                $endingTime[] = [
                    'day' => $day,
                    'end_time' => $end,
                ];
            }
        }

        if (!empty($startingTime) && !empty($endingTime)) {
            $location->startingTime = json_encode($startingTime);
            $location->endingTime = json_encode($endingTime);
        }

        if (empty($startingTime)) {
            $location->startingTime = [
                ['day' => 'Monday', 'start_time' => '09:00'],
                ['day' => 'Tuesday', 'start_time' => '09:00'],
                ['day' => 'Wednesday', 'start_time' => '09:00'],
                ['day' => 'Thursday', 'start_time' => '09:00'],
                ['day' => 'Friday', 'start_time' => '09:00'],
            ];
        }
        
        if (empty($endingTime)) {
            $location->endingTime = [
                ['day' => 'Monday', 'end_time' => '18:00'],
                ['day' => 'Tuesday', 'end_time' => '18:00'],
                ['day' => 'Wednesday', 'end_time' => '18:00'],
                ['day' => 'Thursday', 'end_time' => '18:00'],
                ['day' => 'Friday', 'end_time' => '18:00'],
            ];
        }
        
        $location->save();

        return redirect()->route('locations')->with('success', 'Locatia a fost creata cu succes');
    }

    /**
     * Display the specified resource.
     */
    public function show(location $location)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id, Request $request)
    {
        $user = $request->user();
        
        $location = Location::where('id', $id)->where('user_id', $user->id)->first();

        $service = Services::where('user_id', $user->id)->get();
        $doctor = Doctor::where('user_id', $user->id)->get();
        
        $counties = Counties::orderBy('county_name', 'asc')->get();
        $cities = Cities::get();

        return view('management.location-partials.editLocation', compact('user', 'location', 'counties', 'cities'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $location = Location::findOrFail($id);

        // Optional: Add ownership check
        if (auth()->id() !== $location->user_id) {
            abort(403, 'This action is unauthorized.');
        }

        $fields = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string',
            'state' => 'required|string'
        ]);

        $location->name = $fields['name'];
        $location->address = $fields['address'];
        $location->city = $fields['city'];
        $location->state = $fields['state'];

        $startingTime = [];
        $endingTime = [];
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

        foreach ($days as $day) {
            $workingDayCheck = $request->input("workingDay_$day");
            $start = $request->input("startingTime_$day");
            $end = $request->input("endingTime_$day");

            if ($start && $end) {
                $startingTime[] = [
                    'day' => $day,
                    'start_time' => $start,
                ];
                $endingTime[] = [
                    'day' => $day,
                    'end_time' => $end,
                ];
            }
        }

        if (!empty($startingTime) && !empty($endingTime)) {
            $location->startingTime = json_encode($startingTime);
            $location->endingTime = json_encode($endingTime);
        }

        if (empty($startingTime)) {
            $location->startingTime = [
                ['day' => 'Monday', 'start_time' => '09:00'],
                ['day' => 'Tuesday', 'start_time' => '09:00'],
                ['day' => 'Wednesday', 'start_time' => '09:00'],
                ['day' => 'Thursday', 'start_time' => '09:00'],
                ['day' => 'Friday', 'start_time' => '09:00'],
            ];
        }
        
        if (empty($endingTime)) {
            $location->endingTime = [
                ['day' => 'Monday', 'end_time' => '18:00'],
                ['day' => 'Tuesday', 'end_time' => '18:00'],
                ['day' => 'Wednesday', 'end_time' => '18:00'],
                ['day' => 'Thursday', 'end_time' => '18:00'],
                ['day' => 'Friday', 'end_time' => '18:00'],
            ];
        }
        
        $location->update();

        return redirect()->route('locations')->with('success', 'Locatia a fost modificata cu succes');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $location = Location::findOrFail($id);

        if (!$location) {
            abort(404, 'Locația nu a fost găsită');
        }

        // Șterge serviciile asociate
        $location->service()->delete();

        // Șterge doctorii asociați
        $location->doctor()->delete();

        // Șterge locația
        $location->delete();

        return redirect()->route('locations')->with('success', 'Locația și informațiile asociate au fost șterse.');
    }

}
