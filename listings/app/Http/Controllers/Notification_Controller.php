<?php

namespace App\Http\Controllers;

use App\Models\notification;
use Illuminate\Http\Request;

class Notification_Controller extends Controller
{
    //
    public function Notify()
    {
        if (session('user')) {
            $notif = notification::where('user_id', intval(session('user')->user_id))->whereIn('status', ['Delivered', 'Viewed'])->orderBy('updated_at', 'asc')->get();
            return response()->json($notif);
        } else if (session('admin')) {
            $notif = notification::where('user_id', intval(session('admin')->user_id))->whereIn('status', ['Delivered', 'Viewed'])->orderBy('updated_at', 'asc')->get();
            return response()->json($notif);
        } else {
            $notif = notification::distinct('content')->whereIn('status', ['Delivered', 'Viewed'])->orderBy('updated_at', 'asc')->get();
            return response()->json($notif);
        }
    }
    public function Send_Push_Notification()
    {
        $sending = notification::where('status', 'Sending')->get();
        return response()->json($sending);
    }
    public function Update_Notification($id)
    {
        $sending = notification::where('notif_id', $id)->update(['status' => 'Delivered']);
        return response()->json($sending);
    }
    public function Badge()
    {
        $sending = notification::where('status', 'Delivered')->get();
        return response()->json($sending);
    }
    public function Update_Notification_Viewed($id)
    {
        $check = notification::where('notif_id', $id)->first();
        $contract = notification::where('con_id', $$check->target_id)->first();
        $sending = notification::where('notif_id', $id)->update(['status' => 'Viewed']);
        return response()->json($sending);
    }
}
