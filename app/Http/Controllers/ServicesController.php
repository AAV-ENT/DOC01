<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ServicesController extends Controller
{
    public function create(Request $request) {
        $user = $request->user();

        return view('management.services', [
            'user' => $user
        ]);
    }

    public function store(Request $request) {
        $fields = $request->validate([
            'name' => ['required', 'min:3'],
            'price' => ['required', 'decimal:2', 'min:0'],
            'duration' => ['required', 'numeric']
        ]);

        auth()->user()->services()->create($fields);

        return redirect(route('services'));
    }
    
}
