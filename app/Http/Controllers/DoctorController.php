<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Doctor;
use App\Models\Location;
use App\Models\Services;

class DoctorController extends Controller
{
    public function create(Request $request) {
        $user = $request->user();
        $services = $user->services;

        $location = Location::where('user_id', $user->id)->get();

        return view('management.doctor', compact('user', 'services', 'location'));
    }

    public function store(Request $request) {
        $doctor = new Doctor();
        $user   = $request->user();

        // Validarea datelor primite
        $validatedData = $request->validate([
            'name' => 'required|string|max:255', // Numele medicului
            'location_id' => 'required|exists:locations,id', // Locația selectată
            'doctor_type' => 'required | string',
            'services' => 'required | array', // Lista de servicii selectate
            'services.*' => 'exists:services,id', // Verificăm că fiecare serviciu există
            'otherProgram' => 'nullable|boolean', // Checkbox-ul pentru program separat
        ]);

        // Gestionarea programului personalizat (dacă este bifat)
        if (isset($validatedData['otherProgram']) == 1) {
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

            // Salvarea programului personalizat în baza de date
            if (!empty($startingTime) && !empty($endingTime)) {
                $doctor->startingTime = json_encode($startingTime);
                $doctor->endingTime = json_encode($endingTime);
            }
        } else {
            $location = Location::where('id', $validatedData['location_id'])->where('user_id', $user->id)->first(['startingTime', 'endingTime']);
            $startingTime = $location->startingTime; 
            $endingTime = $location->endingTime;

            $doctor->startingTime = $startingTime;
            $doctor->endingTime = $endingTime;
        }

        $doctor->name = $validatedData['name'];
        $doctor->location_id = $validatedData['location_id'];
        $doctor->user_id = $user->id;
        $doctor->doctor_type = $validatedData['doctor_type'];
        $doctor->save();

        // Asocierea serviciilor cu medicul
        if (!empty($validatedData['services'])) {
            $doctor->services()->sync($validatedData['services']);
        }

        // Redirect sau răspuns JSON
        return redirect()->back()->with('success', 'Locația și medicul au fost adăugați cu succes.');

    }

    public function edit(Request $request, $id) {
        $user = $request->user();
        $doctor = Doctor::where('id', $id)->where('user_id', $user->id)->first();
        $location = Location::where('user_id', $user->id)->get();
        $selectedLocation = Location::where('user_id', $user->id)->where('id', $doctor->location_id)->first();
        $services = Services::all();
        
        
        $doctorId = $id; // Replace with the actual doctor ID

        // Get the services that belong to the doctor
        $doctorServices = DB::table('doctor_services')
            ->where('doctor_id', $doctorId)
            ->pluck('services_id')
            ->toArray();

        // Filter the user's services based on the doctor's services
        $selectedServices = $user->services
            ->whereIn('id', $doctorServices)
            ->pluck('id')
            ->toArray();

        return view('management.doctor-partials.editDoctor', compact('user', 'location', 'selectedLocation', 'doctor', 'selectedServices', 'services'));
    }

    public function returnDoctorsWithServices() {
        $doctorsWithServices = Doctor::with('services')->get();

        // Transform the result to a simple array with doctor names and their services
        $result = $doctorsWithServices->map(function($doctor) {
            return [
                'doctor' => $doctor->name, // Assuming 'name' is a field in the doctors table
                'services' => $doctor->services->pluck('name') // Assuming 'name' is a field in the services table
            ];
        });

        return $result;
    }

    public function update(Request $request, $id) {
        $doctor = Doctor::findOrFail($id);
        $user   = $request->user();

        // Optional: Add ownership check
        if (auth()->id() !== $doctor->user_id) {
            abort(403, 'This action is unauthorized.');
        }

        // Validarea datelor primite
        $validatedData = $request->validate([
            'name' => 'required|string|max:255', // Numele medicului
            'location_id' => 'required|exists:locations,id', // Locația selectată
            'doctor_type' => 'required | string',
            'services' => 'required | array', // Lista de servicii selectate
            'services.*' => 'exists:services,id', // Verificăm că fiecare serviciu există
            'otherProgram' => 'nullable|boolean', // Checkbox-ul pentru program separat
        ]);

        // Gestionarea programului personalizat (dacă este bifat)
        if (isset($validatedData['otherProgram']) == 1) {
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

            // Salvarea programului personalizat în baza de date
            if (!empty($startingTime) && !empty($endingTime)) {
                $doctor->startingTime = json_encode($startingTime);
                $doctor->endingTime = json_encode($endingTime);
            }
        } else {
            $location = Location::where('id', $validatedData['location_id'])->where('user_id', $user->id)->first(['startingTime', 'endingTime']);
            $startingTime = $location->startingTime; 
            $endingTime = $location->endingTime;

            $doctor->startingTime = $startingTime;
            $doctor->endingTime = $endingTime;
        }

        $doctor->name = $validatedData['name'];
        $doctor->location_id = $validatedData['location_id'];
        $doctor->user_id = $user->id;
        $doctor->doctor_type = $validatedData['doctor_type'];
        $doctor->update();

        // Asocierea serviciilor cu medicul
        if (!empty($validatedData['services'])) {
            $doctor->services()->sync($validatedData['services']);
        }

        // Redirect sau răspuns JSON
        return redirect()->back()->with('success', 'Medicul a fost salvat cu success.');

    }

    public function destroy($id)
    {
        $doctor = Doctor::findOrFail($id);

        if (!$doctor) {
            abort(404, 'Doctorul nu a fost gasit');
        }

        // Șterge locația
        $doctor->delete();

        return redirect()->route('doctors')->with('success', 'Locația și informațiile asociate au fost șterse.');
    }

}
