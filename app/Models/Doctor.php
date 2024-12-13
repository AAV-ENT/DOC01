<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = [
        'name',
        'services',
        'location_id',
        'doctor_type',
        'startingTime',
        'endingTime'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function services() {
        return $this->belongsToMany(Services::class);
    }

    public function appointments() {
        return $this->belongsToMany(Appointments::class);
    }

    public function location() {
        return $this->belongsToMany(Location::class);
    }
}
