<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class services extends Model
{
    protected $fillable = [
        'name',
        'price',
        'duration',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function doctor() {
        return $this->belongsToMany(Doctor::class);
    }

    public function appointments() {
        return $this->belongsToMany(Appointments::class);
    }
}
