<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

use App\Models\contract as model;
use App\Models\payments as related;

class Contract_Controller extends Controller
{
    public $ent = 'Contract';

    public function get_locations() {
        $records = model::selectRaw('Distinct location, Count(con_id) As contracts')->whereNot('status', 'Completed')->groupBy('location')->get();

        $data =[
            'records' => $records,
        ];

        return response()->json($data);
    }

    public function get_location(Request $request) {
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

    public function add(Request $request)
    {
        $request->validate([
            'tenant_price' => 'numeric',
            'owner_income' => 'numeric',
            'company_income' => 'numeric',
        ]);

        $record = new model();

        $keys = ['contact', 'contract_start', 'contract_end', 'payment_term', 'tenant_price', 'owner_income', 'company_income', 'payment_date'];
        foreach ($keys as $key) {
            $record->$key = $request->$key;
        }

        $upper_keys = ['location', 'client', 'property_details', 'coordinator', 'agent'];
        foreach ($upper_keys as $key) {
            $record->$key = strtoupper($request->$key);
        }

        $term = str_replace(' ', '', $request->payment_term);
        $term = explode('+', $term);
        $adv = intval(preg_replace("/[^0-9]/", "", $term[0]));

        $term = str_replace(' ', '', $request->payment_date);
        $term = explode('/', $term);
        $day = preg_replace("/[^0-9]/", "", $term[0]);

        $inter = strtolower($term[1]);
        if (str_starts_with($inter, 'semi')) {
            $inter = 6;
        }
        else if (str_starts_with($inter, 'quarter')) {
            $inter = 4;
        }
        else {
            $inter = 1;
        }

        if (isset($request->due_date)) {
            $paid = Carbon::parse($request->due_date)->subMonths($inter);
            $record->due_date = $request->due_date;
        }
        else {
            $paid = Carbon::parse($request->contract_start)->addMonths($adv-1);
            $record->due_date = Carbon::parse($request->contract_start)->addMonths($adv-1+$inter)->day($day);
        }
        
        $record->status = '';
        $record->save();

        $months = CarbonPeriod::create(Carbon::parse($request->contract_start)->day(1), '1 month', $paid->day(1));
        foreach($months as $month) { 
            $last_day = $month->endofMonth()->day;

            $related = new related;
            $related->contract_con_id = $record->con_id;   

            if ($day > $last_day) {
                if (($last_day == 28) || $last_day == 29) {        
                    $related->paid_at = $month->day($last_day)->format('Y-m-d');
                }
            }
            else {
                $related->paid_at = $month->day($day)->format('Y-m-d');
            }

            $related->save();
        }

        return response(['msg' => "Added $this->ent"]);
    }

    public function payment(Request $request)
    {
        $record = model::find($request->id);

        $term = str_replace(' ', '', $record->payment_date);
        $term = explode('/', $term);
        $day = preg_replace("/[^0-9]/", "", $term[0]);
        
        $inter = strtolower($term[1]);
        if (str_starts_with($inter, 'semi')) {
            $inter = 6;
        }
        else if (str_starts_with($inter, 'quarter')) {
            $inter = 4;
        }
        else {
            $inter = 1;
        }

        $last_pay = Carbon::parse($record->due_date)->subMonths($inter);
        $new_due = Carbon::parse($record->due_date)->addMonths($inter)->day($day);

        $months = CarbonPeriod::create($last_pay->addMonths(1)->day(1), '1 month', Carbon::parse($record->due_date)->day(1));
        $record->update(['due_date' => $new_due]);
        foreach($months as $month) { 
            $last_day = $month->endofMonth()->day;

            $related = new related;
            $related->contract_con_id = $record->con_id;   

            if ($day > $last_day) {
                if (($last_day == 28) || $last_day == 29) {        
                    $related->paid_at = $month->day($last_day)->format('Y-m-d');
                }
            }
            else {
                $related->paid_at = $month->day($day)->format('Y-m-d');
            }

            $related->save();
        }

        return response(['msg' => "Payment Processed"]);
    }

    public function edit(Request $request)
    {
        $record = model::find($request->id);

        $data = [
            'record' => $record,
        ];

        return response()->json($data);
    }

    public function upd(Request $request)
    {
        $request->validate([
            'tenant_price' => 'numeric',
            'owner_income' => 'numeric',
            'company_income' => 'numeric',
        ]);

        $record = model::find($request->id);
        $records = related::where('contract_con_id', $request->id)->delete();

        $keys = ['contact', 'contract_start', 'contract_end', 'payment_term', 'tenant_price', 'owner_income', 'company_income', 'payment_date'];
        foreach ($keys as $key) {
            $upd[$key] = $request->$key;
        }

        $upper_keys = ['location', 'client', 'property_details', 'coordinator', 'agent'];
        foreach ($upper_keys as $key) {
            $upd[$key] = strtoupper($request->$key);
        }

        $term = str_replace(' ', '', $request->payment_term);
        $term = explode('+', $term);
        $adv = intval(preg_replace("/[^0-9]/", "", $term[0]));

        $term = str_replace(' ', '', $request->payment_date);
        $term = explode('/', $term);
        $day = preg_replace("/[^0-9]/", "", $term[0]);

        $inter = strtolower($term[1]);
        if (str_starts_with($inter, 'semi')) {
            $inter = 6;
        }
        else if (str_starts_with($inter, 'quarter')) {
            $inter = 4;
        }
        else {
            $inter = 1;
        }

        if (isset($request->due_date)) {
            $paid = Carbon::parse($request->due_date)->subMonths($inter);
            $upd['due_date'] = $request->due_date;
        }
        else {
            $paid = Carbon::parse($request->contract_start)->addMonths($adv-1);
            $upd['due_date'] = Carbon::parse($request->contract_start)->addMonths($adv-1+$inter)->day($day);
        }
        
        $upd['status'] = '';

        $record->update($upd);

        $months = CarbonPeriod::create(Carbon::parse($request->contract_start)->day(1), '1 month', $paid->day(1));
        foreach($months as $month) { 
            $last_day = $month->endofMonth()->day;

            $related = new related;
            $related->contract_con_id = $record->con_id;   

            if ($day > $last_day) {
                if (($last_day == 28) || $last_day == 29) {        
                    $related->paid_at = $month->day($last_day)->format('Y-m-d');
                }
            }
            else {
                $related->paid_at = $month->day($day)->format('Y-m-d');
            }

            $related->save();
        }

        return response(['msg' => "Updated $this->ent"]);
    }

    public function del(Request $request)
    {
        $record = model::find($request->id)->delete();
        $records = related::where('contract_con_id', $request->id)->delete();

        return response(['msg' => "Deleted $this->ent"]);
    }
}
