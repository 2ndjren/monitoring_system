<?php

namespace App\Http\Controllers;

use App\Mail\Send_Payment_Notification_Success;
use App\Models\contract as model;
use App\Models\notification;
use App\Models\payments as related;
use App\Models\user;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class History_Controller extends Controller
{
    public $ent = 'Contract';

    public function get_locations()
    {
        $records = model::selectRaw('Distinct location, Count(con_id) As contracts')->whereNot('status', 'Completed')->groupBy('location')->get();

        $data = [
            'records' => $records,
        ];

        return response()->json($data);
    }

    public function get_location(Request $request)
    {
        $ids = model::select('con_id')->get();
        $today = Carbon::today();
        foreach ($ids as $id) {
            $contract = model::find($id->con_id);

            if ($contract->due_date != null) {
                $due = Carbon::parse($contract->due_date);
                $days = $today->diffInDays($due);

                if ($today > $due) {
                    $status = "$days Days Past Due";
                } else if ($today == $due) {
                    $status = "Today";
                } else {
                    $status = "$days Days Remaining";
                }
            } else {
                $status = null;
            }

            $contract->update(['status' => $status]);
        }

        $records = model::whereNot('status', 'Completed')->where('location', $request->location)->get();

        $months = ['january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'september', 'october', 'november', 'december'];

        foreach ($records as $record) {
            for ($index = 0; $index < count($months); $index++) {
                $count = related::where('contract_con_id', $record['con_id'])
                    ->whereMonth('paid_at', $index + 1)
                    ->whereYear('paid_at', $today->year)
                    ->count('contract_con_id');
                $month = $months[$index];
                $count == 0 ? $record[$month] = null : $record[$month] = 'PAID';
            }
        }

        $data = [
            'records' => $records,
        ];

        return response()->json($data);
    }
}
