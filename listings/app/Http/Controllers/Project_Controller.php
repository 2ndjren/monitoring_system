<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\projects;

class Project_Controller extends Controller
{
    public $entity = 'Project';

    public function get_all() {
        $records = projects::all();
        
        $data = [
            'records' => $records,
        ];

        return response()->json($data);
    }

    public function add(Request $request) {
        $request->validate([
            'project_name'=>'required',
            'project_code'=>'required',
        ]);

        $record = new projects;

        $keys = ['project_name', 'project_code'];
        foreach ($keys as $key) {
            $record->$key = $request->$key;
        }
        $record->save();

        return response(['msg' => "Added $this->entity"]);
    }

    public function edit(Request $request) {
        $record = projects::find($request->id);

        $data = [
            'record' => $record,
        ];

        return response()->json($data);
    }

    public function upd(Request $request) {
        $request->validate([
            'project_name'=>'required',
            'project_code'=>'required',
        ]);

        $record = projects::find($request->id);
        $keys = ['project_name', 'project_code'];

        $upd = [];
        foreach ($keys as $key) {
            $upd[$key] = $request->$key;
        }

        $record->update($upd);

        return response(['msg' => "Updated $this->entity"]);
    }

    public function del(Request $request) {
        $record = projects::find($request->id);
        $record->delete();
        
        return response(['msg' => "Deleted $this->entity"]);
    }
}
