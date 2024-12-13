<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cities extends Model
{
    public function counties() {
        return $this->belongsToMany(Counties::class);
    }
}
