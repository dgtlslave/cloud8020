<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Park;
use App\Vehicle;
use Laravel\Ui\Presets\React;

class ParkController extends Controller
{
    public function index() {
        return view('park.view');
    }

    public function create_view() {
        return view('park.create');
    }

    public function savePark(Request $request) {
        $result = $request->validate([
            'v_p_name' => 'required|min:1|max:255',
            'v_p_address' => 'required|min:10|max:255',
            'start' => 'nullable',
            'end' => 'nullable',
            'vehicles' => 'nullable|array'
        ]);

        if($result) {
            if(!empty($request['start']) && !empty($request['end'])){
                $time = $request['start'] . ' - ' . $request['end'];
            } else {
                $time = 'No data';
            }
            $park = Park::firstOrCreate([
                'name' => $request['v_p_name'],
                'address' => $request['v_p_address'],
                'schedule' => $time
            ]);
                // dd($request['vehicles']);
            if($park && !empty($request['vehicles'])) {
                $vehicles_id = [];
                foreach($request['vehicles'] as $key => $vehicle){
                    $vehicle = Vehicle::firstOrCreate([
                        'vehicles_number' => $vehicle['number'],
                        'driver' => $vehicle['driver']
                    ]);

                    $vehicles_id[] = $vehicle->id;
                }

                $park->vehicles()->sync($vehicles_id);
                $park->save();
            }
            return true;
        } else {
            return false;
        }
    }

    public function getAllPark() {
        return Park::all();
    }

    public function edit_park(Request $request) {
        return Park::where(['id' => $request->id])->get();
        // return view('park.edit', $park);
    }

    // public function editPark(Request $request) {
    //     if(isset($request->id)) {
    //         $city = City::find($request->current_city);
    //         $city->name = $request->update_city;
    //         $city->save();

    //             return 1;
    //         if($request->update_city){
    //             $city = City::find($request->current_city);
    //             $city->name = $request->update_city;
    //             $city->save();

    //             return 1;
    //         }
    //     }
    // }
}


// "vehicles" => []
// "v_p_address" => null
// "v_p_name" => null
// "start" => null
// "end" => null
