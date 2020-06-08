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

    public function edit_view(Request $request){
        // dd($request->park);
        $park = Park::where(['id' => $request->park])->first();
        return view('park.edit', compact('park'));
    }

    public function save_edited_park(Request $request) {

        $count = 0;
        $park = Park::where(['id' => $request->id])->first();

        if($park->name != $request->name) {
            $park->name = $request->name;
            $count++;
        }

        if($park->address != $request->address) {
            $park->address = $request->address;
            $count++;
        }

        if($park->start != $request->start) {
            $park->start = $request->start;
            $count++;
        }

        if($park->end != $request->end) {
            $park->end = $request->end;
            $count++;
        }

        if($count != 0) {
            $park->save();
            return 1;
        } else {
            return 2;
        }
    }

    public function delete_park(Request $request) {
        $park = Park::where(['id' => $request->id])->first();
        // $park->delete();
        return $park;

        Park::where('vehicle_id',$request->id)->get()->each(function ($park) {
            $park->players()->deatch();
            $park->delete();
        });
            $park->delete();
            return $park;
    }

    public function view_vehicle(Request $request) {
        $park = Park::find($request->park)->vehicles()->get();
        return view('vehicle.view', compact('park'));
    }

}
