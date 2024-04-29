<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\contract as model;

class Coordinator_Controller extends Controller
{
    public $ent = 'Coordinator';

    public function get_all()
    {
        $col = strtolower($this->ent);
        $records = model::select($col, 'contact')->distinct($col)->orderBy($col)->whereNot($col, '-')->get();

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
            'coordinator' => 'required',
            'contact' => 'required',
        ]);

        $record = model::where($this->ent, $request->target);
        $keys = ['coordinator', 'contact'];
        
        foreach ($keys as $key) {
            $upd[$key] = strtoupper($request->$key);
        }

        $record->update($upd);

        return response(['msg' => "Updated $this->ent"]);
    }

    public function del(Request $request)
    {
        $record = model::where($this->ent, $request->target);
        $record->update([$this->ent => '-']);

        return response(['msg' => "Deleted $this->ent"]);
    }
}
