<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Vehicle extends Model
{

    use HasRoles;

    protected $fillable = ['vehicles_number', 'driver'];

    public function parks() {
        return $this->belongsToMany(Park::class);
    }
}
