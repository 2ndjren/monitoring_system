<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\clients;

class Client_Controller extends Controller
{
    public $ent = 'Client';

    public function get_all() {
        $records = clients::all();
        
        $data = [
            'records' => $records,
        ];

        return response()->json($data);
    }

    public function add(Request $request) {
        $request->validate([
            'fname'=>'required',
            'lname'=>'required',
            'phone'=>'required',
            'email'=>'required|email',
        ]);

        $record = new clients;

        $keys = ['fname', 'lname', 'phone', 'email'];
        foreach ($keys as $key) {
            $record->$key = $request->$key;
        }
        $record->save();

        return response(['msg' => "Added $this->ent"]);
    }

    public function edit(Request $request) {
        $record = clients::find($request->id);

        $data = [
            'record' => $record,
        ];

        return response()->json($data);
    }

    public function upd(Request $request) {
        $request->validate([
            'fname'=>'required',
            'lname'=>'required',
            'phone'=>'required',
            'email'=>'required|email',
        ]);

        $record = clients::find($request->id);
        $keys = ['fname', 'lname', 'phone', 'email'];

        $upd = [];
        foreach ($keys as $key) {
            $upd[$key] = $request->$key;
        }

        $record->update($upd);

        return response(['msg' => "Updated $this->ent"]);
    }

    public function del(Request $request) {
        $record = clients::find($request->id);
        $record->delete();
        
        return response(['msg' => "Deleted $this->ent"]);
    }
}
