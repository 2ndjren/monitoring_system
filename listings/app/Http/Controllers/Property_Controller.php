<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\contract as model;

class Property_Controller extends Controller
{
    public $ent = 'Property';

    public function get_all()
    {
        $col = strtolower($this->ent);
        $records = model::select($col)->distinct($col)->get();

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
            'property' => 'required',
        ]);

        $record = model::where($this->ent, $request->target);
        $keys = ['property'];

        foreach ($keys as $key) {
            $upd[$key] = $request->$key;
        }

        $record->update($upd);

        return response(['msg' => "Updated $this->ent"]);
    }

    public function del(Request $request)
    {
        $record = model::where($this->ent, $request->target);
        $record->delete();

        return response(['msg' => "Deleted $this->ent"]);
    }
}
