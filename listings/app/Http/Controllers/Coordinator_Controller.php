<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\coordinators;

class Coordinator_Controller extends Controller
{
    public $ent = 'Coordinators';

    public function get_all() {
        $records = coordinators::all();
        
        $data = [
            'records' => $records,
        ];

        return response()->json($data);
    }

    public function add(Request $request) {
        $request->validate([
            'co_fname'=>'required',
            'co_lname'=>'required',
            'co_phone'=>'required',
        ]);

        $record = new coordinators;

        $keys = ['co_fname', 'co_lname', 'co_phone'];
        foreach ($keys as $key) {
            $record->$key = $request->$key;
        }
        $record->save();

        return response(['msg' => "Added $this->ent"]);
    }

    public function edit(Request $request) {
        $record = coordinators::find($request->id);

        $data = [
            'record' => $record,
        ];

        return response()->json($data);
    }

    public function upd(Request $request) {
        $request->validate([
            'co_fname'=>'required',
            'co_lname'=>'required',
            'co_phone'=>'required',
        ]);


        $record = coordinators::find($request->id);
        $keys = ['co_fname', 'co_lname', 'co_phone'];

        $upd = [];
        foreach ($keys as $key) {
            $upd[$key] = $request->$key;
        }

        $record->update($upd);

        return response(['msg' => "Updated $this->ent"]);
    }

    public function del(Request $request) {
        $record = coordinators::find($request->id);
        $record->delete();
        
        return response(['msg' => "Deleted $this->ent"]);
    }
}