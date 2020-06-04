<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Park extends Model
{
    protected $fillable = ['name', 'address', 'schedule'];

    public function vehicles() {
        return $this->belongsToMany(Vehicle::class);
    }
}
