<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Park extends Model
{

    use HasRoles;

    protected $fillable = ['name', 'address', 'schedule'];

    public function vehicles() {
        return $this->belongsToMany(Vehicle::class);
    }
}
