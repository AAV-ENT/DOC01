<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointments extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_type',
        'service_id',
        'doctor_id',
        'location_id',
        'appointment_type',
        'name',
        'phone',
        'email',
        // 'ssn', 
        'date',
        'hour',
        'minute'
    ];

    public function doctor() {
        return $this->belongsToMany(Doctor::class, 'appointments_doctor');
    }

    public function services() {
        return $this->belongsToMany(Services::class, 'appointments_services');
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
