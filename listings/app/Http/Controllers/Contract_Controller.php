<?php

namespace App\Http\Controllers;

use App\Mail\Send_Contract_Has_Ended_Message;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Carbon\CarbonPeriod;

use App\Models\contract as model;
use App\Models\notification;

class Contract_Controller extends Controller
{
    public $ent = 'Contract';

    public function get_all()
    {
        $ids = model::select('con_id')->get();
        $today = Carbon::today();
        foreach ($ids as $id) {
            $contract = model::find($id->con_id);
            // if ($id->contract_end <= $today) {
            //     $contract->update(['status' => 'Completed']);
            //     $notif = new notification();
            //     $notif->target_id = $contract->con_id;
            //     $notif->target_model = "contract";
            //     $notif->heading = "Contract Completed";
            //     $notif->content = "The property " . $contract->property . " - " . $contract->building . " " . $contract->unit . "(" . $contract->unit_type . ") contract has ended.";
            //     $notif->notified = "0";
            //     $notif->status = "Delivered";
            //     $notif->save();
            // } else {
            //     $due = Carbon::parse($contract->due_date);
            //     $days = $today->diffInDays($due);
            //     $today > $due ? $status = "$days Days Past Due" : $status = "$days Days Remaining";

            //     $contract->update(['status' => $status]);
            // }
            $due = Carbon::parse($contract->due_date);
            $days = $today->diffInDays($due);
            $today > $due ? $status = "$days Days Past Due" : $status = "$days Days Remaining";

            $contract->update(['status' => $status]);
        }


        $records = model::whereNot('status', ['Completed'])->get();

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

        if (empty($record->due_date)) {
            $due = Carbon::parse($request->contract_start)->addMonths($adv)->day($day);
            $record->due_date = Carbon::parse($request->contract_start)->addMonths(intval($adv)+$inter)->day($day);
        }
        else {
            $record->due_date = $request->due_date;
        }
        
        $record->status = '';

        $record->save();

        $months = CarbonPeriod::create($record->contract_start, '1 month', $due->subMonths(1));
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

        $old_due = Carbon::parse($record->due_date)->subMonths($inter)->day($day);
        $new_due = Carbon::parse($record->due_date)->day($day);

        $months = CarbonPeriod::create($old_due, '1 month', $new_due->subMonths(1));
        $record->update(['due_date' => $new_due->addMonths($inter)]);
        foreach($months as $month) { 
            $related = new related;

            $related->contract_con_id = $record->con_id;
            $related->paid_at = $month->day($day)->format('Y-m-d');
            
            $related->save();
        }

        // return response(['msg' => "Payment Processed"]);

        $data = [
            'old_due' => $old_due,
            'new_due' => $new_due,
            'months' => $months,
        ];
        return response()->json($data);
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
