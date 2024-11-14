<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function create(Request $request) {
        $user = $request->user();
        $services = $user->services;

        return view('management.doctor', [
            compact('services'),
            'user' => $user
        ]);
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'services' => ['array'],
            'services.*' => ['integer', 'exists:services,id'],
        ]);

        $doctor = auth()->user()->doctor()->create([
            'name' => $validated['name']
        ]);
        $doctor->services()->attach($validated['services']);

        return redirect()->route('doctors')->with('success', 'Doctor added successfully.');
    }

}
