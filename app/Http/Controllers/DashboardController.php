<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DateTime;

use Carbon\Carbon;

use App\Models\Location;
use App\Models\Services;
use App\Models\Doctor;
use App\Models\Appointments;

class DashboardController extends Controller
{
    private function isDate($date, $format = 'Y-m-d') {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }

    public function create(Request $request, $search = null) {
        if (!$search) {
            $search = now()->format('Y-m-d');  // Use Carbon to get today's date in Y-m-d format
            return redirect()->route('dashboard', ['search' => $search]);
        }    

        $user = $request->user();

        $services = Services::where('user_id', $user->id)->get();

        $doctors = Doctor::where('user_id', $user->id)->get();

        $location = Location::where('user_id', $user->id)->get();

        if($this->isDate($search)) {
            $appointments = Appointments::where('user_id', $user->id)->where('date', $search)->get();
        } else {
            $appointments = Appointments::where('user_id', $user->id)->where('phone', $search)->get();
        }

        return view('management.dashboard', compact('user', 'services', 'doctors', 'location', 'appointments'));
    }

    public function search(Request $request) {

        $validateData = $request->validate([
            'phone' => 'nullable|digits_between:9,15|required_without:date',
            'date'  => 'nullable|string|required_without:phone',
        ]);

        // Parse Flatpickr date and convert to Y-m-d format
        if(!empty($validateData['date'])) {
            $flatpickrDate = $validateData['date'];
            try {
                $convertedDate = Carbon::createFromFormat('d-m-Y', $flatpickrDate)->format('Y-m-d');
                $validateData['date'] = $convertedDate;
            } catch (\Exception $e) {
                return back()->withErrors(['date' => 'Invalid date format.']);
            }
        }

        if(!empty($validateData['phone'])) {
            return redirect()->route('dashboard', ['search' => $validateData['phone']]);
        } else {
            return redirect()->route('dashboard', ['search' => $validateData['date']]);
        }
    }
}
