<?php

namespace App\Http\Controllers;

use App\Models\agents as model;
use Illuminate\Http\Request;

class Agent_Controller extends Controller
{
    //
    public $ent = 'Client';

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
            'agent_fname' => 'required',
            'agent_lname' => 'required',
            'agent_phone' => 'required',
            'agent_email' => 'required|email',
        ]);

        $record = new model;

        $keys = ['agent_fname', 'agent_lname', 'agent_phone', 'agent_email'];
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
            'agent_fname' => 'required',
            'agent_lname' => 'required',
            'agent_phone' => 'required',
            'agent_email' => 'required|email',
        ]);

        $record = model::find($request->id);
        $keys = ['agent_fname', 'agent_lname', 'agent_phone', 'agent_email'];


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
