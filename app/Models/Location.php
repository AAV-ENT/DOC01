<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
        'name',
        'address',
        'city',
        'state',
        'startingTime',
        'endingTime'
    ];

    protected $casts = [
        'startingTime' => 'json',
        'endingTime' => 'json',
    ];

    public function cities() {
        return $this->hasMany(Cities::class);
    }

    public function counties() {
        return $this->hasMany(Counties::class);
    }

    public function service() {
        return $this->hasMany(Services::class);
    }

    public function doctor() {
        return $this->hasMany(Doctor::class);
    }
}
