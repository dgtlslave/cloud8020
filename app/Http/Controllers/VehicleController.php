<?php

namespace App\Http\Controllers;

use App\Park;
use App\User;
use App\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasPermissions;

class VehicleController extends Controller
{
    use HasRoles;

    public function create_view() {
        return view('vehicle.create');
    }

    public function edit_view(Request $request){
        $vehicle = Vehicle::where(['id' => $request->vehicle])->first();
        return view('vehicle.edit', compact('vehicle'));
        // if(empty($vehicle)) {
        //     $park = Park::where([''])
        // } else {
        //     return view('vehicle.edit', compact('vehicle'));
        // }
    }

    public function saveVehicle(Request $request) {
        // $result = $request->validate([
        //     'vehicles' => 'required|array'
        // ]);
        $result = true;
        if($result) {
            if(!empty($request['start']) && !empty($request['end'])){
                $time = $request['start'] . ' - ' . $request['end'];
            } else {
                $time = 'No data';
            }
            // $park = Park::find($request['vehicles'][0]['id']);
                // dd($request['vehicles']);
            if(!empty($request['vehicles'])) {
                foreach($request['vehicles'] as $key => $vehicle){
                    $this->save_one_vehicle($vehicle);
                }
            }
            return true;
        } else {
            return false;
        }
    }

    public function save_one_vehicle($array) {
        // dd($array);
        if(!empty($array)) {
            $park_id = [];


                $one = Vehicle::firstOrCreate([
                    'vehicles_number' => $array['number'],
                    'driver' => $array['driver']
                ]);
                $park_id[] = $array['park'];

            $one->parks()->sync($park_id);
            $one->save();
        }

    }

    public function delete_vehicle(Request $request) {
        // dd($request->id);
        $vehicle = Vehicle::where(['id' => $request->id])->sharedLock()->first();
        $vehicle->delete();
        return $vehicle;
    }

    public function get_auth_user() {
        $permissions_array = [];
        $user = Auth::user();
        $permissions = $user->getAllPermissions();

        foreach($permissions as $k => $name) {
            $permissions_array[] = $name['name'];
        }
        return  $permissions_array;
    }
}
