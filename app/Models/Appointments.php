<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointments extends Model
{
    use HasFactory;

    public function clients() {
        return $this->belongsTo(Clients::class);
    }

    public function doctor() {
        return $this->hasMany(Doctor::class);
    }

    public function services() {
        return $this->hasMany(Services::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
