<?php

namespace App\Http\Controllers;

use App\Models\buildings as model;
use Illuminate\Http\Request;

class Building_Controller extends Controller
{
    public $ent = 'Building';

    public function get_all()
    {
        $records = model::all();

        $data = [
            'records' => $records,
        ];

        return response()->json($data);
    }
    public function get_all_data($id)
    {
        $records = model::where('projects_id', $id)->get();

        $data = [
            'records' => $records,
        ];

        return response()->json($data);
    }

    public function add(Request $request)
    {
        $request->validate([
            'building_name' => 'required',
            'city' => 'required',
            'barangay' => 'required',
            'street' => 'required',
        ]);

        $record = new model;

        $keys = ['projects_id', 'building_name', 'city', 'barangay', 'street'];
        foreach ($keys as $key) {
            $record->$key = ucwords($request->$key);
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
            'building_name' => 'required',
            'city' => 'required',
            'barangay' => 'required',
            'street' => 'required',
        ]);

        $record = model::find($request->id);
        $keys = ['building_name', 'city', 'barangay', 'street'];
        $upd = [];
        foreach ($keys as $key) {
            $upd[$key] = ucwords($request->$key);
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
