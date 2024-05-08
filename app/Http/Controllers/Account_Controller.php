<?php

namespace App\Http\Controllers;

use App\Models\user as model;
use Illuminate\Http\Request;

class Account_Controller extends Controller
{
    //
    public $ent = 'Account';

    public function get_all()
    {
        $col = strtolower($this->ent);
        $records = model::all();

        $data = [
            'records' => $records,
        ];

        return response()->json($data);
    }

    public function add(Request $request)
    {
        $request->validate([
            'avatar' => 'required',
            'user_fname' => 'required',
            'user_lname' => 'required',
            'email' => 'required',
            'contact' => 'required',
            'username' => 'required',
            'password' => 'required',
        ]);

        $record = new model();
        $keys = ['user_fname', 'user_lname', 'contact', 'email', 'username', 'password', 'role'];

        foreach ($keys as $key) {
            $record->$key = $request->$key;
        }
        $ran = mt_rand(111111111, 999999999);
        $avatar = $request->file('avatar');
        $imageavatar = $ran . '.' . $avatar->extension();
        $avatar->move('account/profile/', $imageavatar);
        $record->avatar = $imageavatar;
        $record->status = "Offline";
        $record->save();

        return response(['msg' => "Adding of $this->ent successful"]);
    }

    public function edit($id)
    {
        $record = model::where('user_id', $id)->first();
        $data = [
            'record' => $record,
        ];

        return response()->json($data);
    }

    public function upd(Request $request)
    {
        $request->validate([
            'user_fname' => 'required',
            'user_lname' => 'required',
            'email' => 'required |unique:user,email',
            'contact' => 'required',
            'username' => 'required',
            'password' => 'required',
        ]);


        $record = model::where('user_id', $request->user_id);

        if ($request->hasFile('avatar')) {
            $ran = mt_rand(111111111, 999999999);
            $avatar = $request->file('avatar');
            $imageavatar = $ran . '.' . $avatar->extension();
            $avatar->move('account/profile/', $imageavatar);
            $record->update(['avatar' => $imageavatar, 'user_fname' => strtoupper($request->user_fname), 'user_lname' => strtoupper($request->user_lname), 'contact' => $request->contact, 'email' => $request->email, 'username' => $request->username, 'password' => password_hash($request->password, PASSWORD_DEFAULT)]);
            return response(['msg' => "Updated $this->ent"]);
        } else {
            $record->update(['user_fname' => strtoupper($request->user_fname), 'user_lname' => strtoupper($request->user_lname), 'contact' => $request->contact, 'email' => $request->email, 'username' => $request->username, 'password' => password_hash($request->password, PASSWORD_DEFAULT)]);
            return response(['msg' => "Updated $this->ent"]);
        }
    }

    public function del(Request $request)
    {
        $record = model::where('user_id', $request->target)->delete();
        return response(['msg' => "Deleted $this->ent"]);
    }
}
