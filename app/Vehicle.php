<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = ['vehicles_number', 'driver'];

    public function parks() {
        return $this->belongsToMany(Park::class);
    }
}
