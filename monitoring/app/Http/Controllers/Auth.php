<?php

namespace App\Http\Controllers;

use App\Models\users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class Auth extends Controller
{
    public function Login(Request $request)
    {
        $rules = [
            'username' => 'required',
            'password' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['status' => 400, 'errors' => $validator->errors()]);
        }
        $match = users::where('username', $request->username)->first();
        if ($match) {
            if (password_verify($request->password, $match->password)) {
                Session::flush();
                if ($match->status == "Online") {
                    return response()->json(['status' => 400, 'message' => 'Your account is already logged in in someone device.']);
                } else {
                    $change = users::where('user_id', $match->user_id)->update([
                        'status' => 'Online'
                    ]);
                    $updated = users::where('user_id', $match->user_id)->first();
                    $data = [
                        'user_id' => $updated->user_id,
                        'fname' => $updated->fname,
                        'lname' => $updated->lname,
                        'status' => $updated->status,
                    ];
                    Session::put('user', $data);
                    if ($updated) {
                        Session::put('user', $updated);
                        return response()->json(['status' => 200, 'user_account' => $updated]);
                    } else {
                        return response()->json(['status' => 400, 'message' => 'Something went wrong']);
                    }
                }
            } else {
                return response()->json(['status' => 400, 'message' => 'Password wrong']);
            }
        } else if ($request->username == "admin" && $request->password == "1234") {
            $data = [
                'fname' => 'IT',
                'lname' => 'Admin',
                'status' => 'Online',
                'email' => 'admin@gmail.com',
            ];
            Session::put('admin', $data);
            return response()->json(['status' => 200, 'user_account' => $data]);
        } else {
            return response()->json(['status' => 400, 'message' => 'Account is not exist']);
        }
    }
    public function Logout()
    {
        if (Session::exists('admin')) {
            Session::flush();
            return redirect('/');
        } else if (Session::exists('user')) {
            $change = users::where('user_id', Session::get('user')['user_id'])->update([
                'status' => 'Offline'
            ]);
            Session::flush();
            return redirect('/');
        }
    }
}
