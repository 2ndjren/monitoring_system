<?php

namespace App\Http\Controllers;

use App\Models\units as model;
use Illuminate\Http\Request;

class Unit_Controller extends Controller
{
    //
    //
    public $ent = 'Unit';

    public function get_all_data($id)
    {
        $records = model::where('buildings_b_id', $id)->get();

        $data = [
            'records' => $records,
        ];

        return response()->json($data);
    }

    public function add(Request $request)
    {
        $request->validate([
            'unit_no' => 'required',
            'unit_type' => 'required',
        ]);

        $record = new model;

        $keys = ['unit_no', 'unit_type'];
        foreach ($keys as $key) {
            $record->$key = $request->$key;
        }
        $record->save();

        return response(['msg' => "Added $this->ent"]);
    }

    public function edit(Request $request)
    {
        $record = model::find($request->id);

        $data = [
            'record' => $record,
        ];

        return response()->json($data);
    }

    public function upd(Request $request)
    {
        $request->validate([
            'unit_no' => 'required',
            'unit_type' => 'required',

        ]);

        $record = model::find($request->id);
        $keys = ['unit_no', 'unit_type'];


        $upd = [];
        foreach ($keys as $key) {
            $upd[$key] = $request->$key;
        }

        $record->update($upd);

        return response(['msg' => "Updated $this->ent"]);
    }

    public function del(Request $request)
    {
        $record = model::find($request->id);
        $record->delete();

        return response(['msg' => "Deleted $this->ent"]);
    }
}
