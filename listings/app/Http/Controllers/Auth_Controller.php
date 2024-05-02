<?php

namespace App\Http\Controllers;

use App\Models\user;
use Illuminate\Http\Request;

class Auth_Controller extends Controller
{
    //
    public function SignIn(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
        if ($request->username == "admin" && $request->password == "1234") {
            session()->put('admin', 'Super Admin');
            return response()->json(['status' => 200, 'msg' => 'Welcome back Admin']);
        }
        $match = user::where('username', $request->username)->first();
        if ($match) {
            if ([password_verify($request->password, $match->password)]) {
                session()->put('user', $match);
                user::where('user_id', $match->user_id)->update(['status' => 'Online']);
                return response()->json(['status' => 200, 'msg' => 'Welcome back ' . $match->user_fname . '', 'user' => $match]);
            } else {

                return response()->json(['status' => 400, 'msg' => 'Username or Password wrong!']);
            }
        } else {
            return response()->json(['status' => 400, 'msg' => 'Username or Password wrong!']);
        }
    }
    public function SignOut()
    {
        if (session('user')) {
            user::find(session('user')->user_id)->update(['status', 'Offline']);
        }
        session()->flush();
        return redirect('/');
    }
}
