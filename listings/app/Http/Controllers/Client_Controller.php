<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\contract as model;

class Client_Controller extends Controller
{
    public $ent = 'Client';

    public function get_all()
    {
        $col = strtolower($this->ent);
        $records = model::select($col)->distinct($col)->orderBy($col)->whereNot($col, '-')->get();

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
            'client' => 'required',
        ]);

        $record = model::where($this->ent, $request->target);
        $keys = ['client'];

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
