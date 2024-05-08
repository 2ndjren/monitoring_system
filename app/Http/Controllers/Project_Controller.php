<?php

namespace App\Http\Controllers;

use App\Models\buildings;
use Illuminate\Http\Request;

use App\Models\projects as model;
use App\Models\units;

class Project_Controller extends Controller
{
    public $ent = 'Project';

    public function get_all()
    {
        $records = model::all();

        $data = [
            'records' => $records,
        ];

        return response()->json($data);
    }

    public function add(Request $request)
    {
        $request->validate([
            'project_name' => 'required',
            'project_code' => 'required',
        ]);

        $record = new model;

        $keys = ['project_name', 'project_code'];
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
            'project_name' => 'required',
            'project_code' => 'required',
        ]);

        $record = model::find($request->id);
        $keys = ['project_name', 'project_code'];

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
        $building = buildings::where('projects_id', $request->id)->first();
        units::where('buildings_b_id', $building->b_id)->delete();
        buildings::where('projects_id', $request->id)->delete();
        $record->delete();
        return response(['msg' => "Deleted $this->ent"]);
    }
}
