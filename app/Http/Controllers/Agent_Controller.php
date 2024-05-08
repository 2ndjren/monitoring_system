<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\contract as model;

class Agent_Controller extends Controller
{
    public $ent = 'Agent';

    public function get_all()
    {
        $col = strtolower($this->ent);
        $records = model::select($col)->distinct($col)->orderBy($col)->whereNotNull($col)->get();

        $data = [
            'records' => $records,
        ];

        return response()->json($data);
    }

    public function edit(Request $request)
    {
        $record = model::where($this->ent, $request->target)->first();
        $data = [
            'record' => $record,
        ];

        return response()->json($data);
    }

    public function upd(Request $request)
    {
        $request->validate([
            'agent' => 'required',
        ]);

        $record = model::where($this->ent, $request->target);
        $keys = ['agent'];

        foreach ($keys as $key) {
            $upd[$key] = strtoupper($request->$key);
        }

        $record->update($upd);

        return response(['msg' => "Updated $this->ent"]);
    }

    public function del(Request $request)
    {
        $record = model::where($this->ent, $request->target);
        $record->update([$this->ent => null]);

        return response(['msg' => "Deleted $this->ent"]);
    }
}
