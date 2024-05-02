<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

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
            'client' => 'required',
            'property' => 'required',
            'building' => 'required',
            'unit' => 'required',
            'unit_type' => 'required',
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

        $keys = ['unit', 'unit_type', 'contact', 'contract_start', 'contract_end', 'payment_term', 'tenant_price', 'owner_income', 'company_income', 'payment_date', 'due_date'];

        $record = new model();

        foreach ($keys as $key) {
            $record->$key = $request->$key;
        }

        $upper_keys = ['client', 'property', 'building', 'coordinator', 'agent'];
        foreach ($upper_keys as $key) {
            $record->$key = strtoupper($request->$key);
        }

        $record->status = '';

        $record->save();

        return response(['msg' => "Added $this->ent"]);
    }

    public function payment(Request $request)
    {
        $record = model::find($request->id);

        $term = str_replace(' ', '', $record->payment_date);
        $term = explode('/', $term);
        $day = preg_replace("/[^0-9]/", "", $term[0]);
        
        if (str_starts_with($term[1], 'semi')) {
            $months = 6;
        }
        else if (str_starts_with($term[1], 'quarter')) {
            $months = 4;
        }
        else {
            $months = 1;
        }

        $due = Carbon::parse($record->due_date)->addMonths($months)->day($day);

        $record->update(['due_date' => $due]);

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
            'client' => 'required',
            'property' => 'required',
            'building' => 'required',
            'unit' => 'required',
            'unit_type' => 'required',
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
        $keys = ['unit', 'unit_type', 'contact', 'contract_start', 'contract_end', 'payment_term', 'tenant_price', 'owner_income', 'company_income', 'payment_date', 'due_date'];

        foreach ($keys as $key) {
            $upd[$key] = $request->$key;
        }

        $upper_keys = ['client', 'property', 'building', 'coordinator', 'agent'];
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
