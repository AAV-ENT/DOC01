<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Counties extends Model
{
    public function cities() {
        return $this->hasMany(Counties::class);
    }
}
