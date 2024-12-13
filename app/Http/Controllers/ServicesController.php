<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Services;
use App\Models\Location;

class ServicesController extends Controller
{
    public function create(Request $request) {
        $user = $request->user();

        $location = Location::where('user_id', $user->id)->get();

        return view('management.services', compact('user', 'location'));
    }

    public function store(Request $request) {
        $fields = $request->validate([
            'name' => ['required', 'min:3'],
            'price' => ['required', 'min:0'],
            'duration' => ['required', 'numeric'],
            'description' => [],
            'location_id' => ['required', 'array']
        ]);

        $fields['location_id'] = json_encode($fields['location_id']);
        
        auth()->user()->services()->create($fields);

        return redirect()->route('services')->with('success', 'Serviciul a fost adaugat cu succes.');
    }

    public function edit(Request $request, $id) {
        $user = $request->user();

        $location = Location::where('user_id', $user->id)->get();
        $services = Services::where('id', $id)->where('user_id', $user->id)->first();

        return view('management.services-partials.editService', compact('user', 'location', 'services'));
    }

    public function update(Request $request, $id) {
        $service = Services::findOrFail($id);

        if (auth()->id() !== $service->user_id) {
            abort(403, 'This action is unauthorized.');
        }

        $validate = $request->validate([
            'name' => ['required', 'min:3'],
            'price' => ['required', 'min:0'],
            'duration' => ['required', 'numeric'],
            'description' => [],
            'location_id' => ['required', 'array']
        ]);

        $validate['location_id'] = json_encode($fields['location_id']);
        $service->update($validate);

        return redirect()->route('services')->with('success', 'Serviciu modificat cu succes');
    }

    public function destroy($id) {
        $service = Services::findOrFail($id);

        if (!$service) {
            abort(404, 'Serviciul nu a fost găsită');
        }

        $service->delete();

        return redirect()->route('services')->with('success', 'Serviciul a fost sters cu succes.');
    }
    
}
