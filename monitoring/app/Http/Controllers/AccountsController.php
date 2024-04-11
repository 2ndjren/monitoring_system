<?php

namespace App\Http\Controllers;

use App\Models\users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AccountsController extends Controller
{
    //
    public function Create_Account(Request $request)
    {
        $rules = [
            'fname' => 'required',
            'lname' => 'required',
            'email' => 'required|unique:users,email',
            'username' => 'required|unique:users,username',
            'password' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['status' => 400, 'errors' => $validator->errors()]);
        }
        $user = new users();
        $id = mt_rand(111111111, 999999999);;
        $user->user_id = $id;
        $user->fname = ucfirst($request->fname);
        $user->lname = ucfirst($request->lname);
        $user->email = $request->email;
        $user->username = $request->username;
        $user->password = password_hash($request->password, PASSWORD_DEFAULT);
        $user->status = "Offline";
        $user->token = mt_rand(111111, 999999);
        $saved = $user->save();
        if ($saved) {
            return response()->json(['status' => 200, 'message' => 'New user successfully created.']);
        } else {
            return response()->json(['status' => 400, 'message' => 'Something went wrong, please try again.']);
        }
    }

    public function User_Accounts()
    {
        $users = users::all();
        $count = count($users);
        if ($count > 0) {
            return response()->json(['status' => 200, 'accounts' => $users]);
        } else {
            return response()->json(['status' => 400, 'message' => 'No users found']);
        }
    }
    public function Get_User_Account($id)
    {
        $user = users::where('user_id', $id)->first();
        if ($user) {
            return response()->json(['status' => 200, 'user' => $user]);
        } else {
            return response()->json(['status' => 400, 'message' => 'User not found']);
        }
    }
}
