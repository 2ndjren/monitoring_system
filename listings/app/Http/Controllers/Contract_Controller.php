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

    public function get_all()
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
                }
                else if ($today == $due) {
                    $status = "Today";
                }
                else {
                    $status = "$days Days Remaining";
                }

            }
            else {
                $status = null;
            }

            $contract->update(['status' => $status]);
        }


        $records = model::whereNot('status', 'Completed')->get();

        $months = ['january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'september', 'october', 'november', 'december'];

        foreach ($records as $record) {
            for ($index = 0; $index < count($months); $index++) {
                $count = related::where('contract_con_id', $record['con_id'])
                            ->whereMonth('paid_at', $index+1)
                            ->whereYear('paid_at', Carbon::now()->year)
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
            'location' => 'required',
            'client' => 'required',
            'property_details' => 'required',
            'coordinator' => 'required',
            'contact' => 'required',
            'agent' => 'required',
            'contract_start' => 'required',
            'contract_end' => 'required',
            'payment_term' => 'required',
            'tenant_price' => 'required|numeric',
            'owner_income' => 'required|numeric',
            'company_income' => 'required|numeric',
            'payment_date' => 'required',
        ]);

        $keys = ['contact', 'contract_start', 'contract_end', 'payment_term', 'tenant_price', 'owner_income', 'company_income', 'payment_date'];

        $record = new model();

        foreach ($keys as $key) {
            $record->$key = $request->$key;
        }

        $upper_keys = ['location', 'client', 'property_details', 'coordinator', 'agent'];
        foreach ($upper_keys as $key) {
            $record->$key = strtoupper($request->$key);
        }

        $term = str_replace(' ', '', $request->payment_term);
        $term = explode('+', $term);
        $adv = preg_replace("/[^0-9]/", "", $term[0]);

        $term = str_replace(' ', '', $request->payment_date);
        $term = explode('/', $term);
        $day = preg_replace("/[^0-9]/", "", $term[0]);

        if (empty($record->due)) {
            $record->due_date = Carbon::parse($request->due_date)->addMonths($adv)->day($day);
        }
        else {
            $record->due_date = $request->due_date;
        }

        $record->status = '';

        $record->save();

        $months = CarbonPeriod::create($record->contract_start, '1 month', $record->due_date->subMonths(1));
        foreach($months as $month) { 
            $related = new related;

            $related->contract_con_id = $record->con_id;
            $related->paid_at = $month->day($day)->format('Y-m-d');
            
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
        
        $months = strtolower($term[1]);
        if (str_starts_with($months, 'semi')) {
            $months = 6;
        }
        else if (str_starts_with($months, 'quarter')) {
            $months = 4;
        }
        else {
            $months = 1;
        }

        $due = Carbon::parse($record->due_date)->addMonths($months)->day($day);

        $record->update(['due_date' => $due]);

        $months = CarbonPeriod::create($record->due_date, '1 month', $due->subMonths(1));
        foreach($months as $month) { 
            $related = new related;

            $related->contract_con_id = $record->con_id;
            $related->paid_at = $month->day($day)->format('Y-m-d');
            
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
            'location' => 'required',
            'client' => 'required',
            'property_details' => 'required',
            'coordinator' => 'required',
            'contact' => 'required',
            'agent' => 'required',
            'contract_start' => 'required',
            'contract_end' => 'required',
            'payment_term' => 'required',
            'tenant_price' => 'required|numeric',
            'owner_income' => 'required|numeric',
            'company_income' => 'required|numeric',
            'payment_date' => 'required',
            'due_date' => 'required',
        ]);

        $record = model::find($request->id);
        $keys = ['contact', 'contract_start', 'contract_end', 'payment_term', 'tenant_price', 'owner_income', 'company_income', 'payment_date', 'due_date'];

        foreach ($keys as $key) {
            $upd[$key] = $request->$key;
        }

        $upper_keys = ['location', 'client', 'property_details', 'coordinator', 'agent'];
        foreach ($upper_keys as $key) {
            $upd[$key] = strtoupper($request->$key);
        }

        $record->update($upd);

        return response(['msg' => "Updated $this->ent"]);
    }

    public function del(Request $request)
    {
        $record = model::find($request->id);
        $record->delete();

        return response(['msg' => "Deleted $this->ent"]);
    }
}
