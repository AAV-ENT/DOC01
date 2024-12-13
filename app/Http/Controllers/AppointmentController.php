<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use App\Models\Appointments;

use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function create(Request $request) {
        $user = $request->user();

        $settings = Settings::first(); // Assuming a single settings record
        $startingTime = $settings->startingTime;
        $endingTime = $settings->endingTime;

        $doctors = $user->doctor;
        $doctorAndServices = [];

        foreach ($doctors as $doctor) {
            // Add the doctor data as an array
            $doctorAndServices[] = [
                'doctor' => $doctor,  // Includes doctor data
                'services' => $doctor->services // Includes related services
            ];
        }

        return view('management.create-appointment', [
            'user' => $user,
            compact('startingTime', 'endingTime'),
            'doctor' => $doctorAndServices
        ]);
    }

    public function store(Request $request)
    {
        $appointment = new Appointments();
        $user   = $request->user();

        // Validarea datelor primite
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|digits_between:1,15',
            'email' => 'required|email|max:255',
            'service_id' => 'required|int|exists:services,id',
            'location_id' => 'required|int|exists:locations,id',
            'doctor_id' => 'required|int|exists:doctors,id',
            'appointment_type' => 'required|string',
            'date' => 'required|date_format:Y-m-d',
            'time' => 'required|date_format:H:i',
        ]);

        $hour = explode(':', $validatedData['time'])[0];
        $min  = explode(':', $validatedData['time'])[1];

        // Gestionarea programului personalizat (dacă este bifat)
        $appointment->user_id = $user->id;
        $appointment->user_type = 'staff';
        $appointment->created_by = $user->id;
        $appointment->name = $validatedData['name'];
        $appointment->phone = $validatedData['phone'];
        $appointment->email = $validatedData['email'];
        $appointment->appointment_type = $validatedData['appointment_type'];
        $appointment->service_id = (int)$validatedData['service_id'];
        $appointment->location_id = (int)$validatedData['location_id'];
        $appointment->doctor_id = (int)$validatedData['doctor_id'];
        $appointment->date = $validatedData['date'];
        $appointment->hour = $hour; 
        $appointment->minute = $min;

        $appointment->save();

        $search = now()->format('Y-m-d');  // Use Carbon to get today's date in Y-m-d format

        // Redirect sau răspuns JSON
        return redirect()->route('dashboard', ['search' => $search])->with('success', 'Programarea a fost salvata cu succes.');
    }
}
