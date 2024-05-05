<?php

namespace App\Http\Controllers;

use App\Models\contract as model;
use App\Models\payments as related;
use Carbon\Carbon;
use Illuminate\Http\Request;

class History_Controller extends Controller
{
    //

    public $ent = 'Contract';

    public function get_all()
    {

        $records = model::where('status', 'Completed')->get();

        $months = ['january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'september', 'october', 'november', 'december'];

        foreach ($records as $record) {
            for ($index = 0; $index < count($months); $index++) {
                $count = related::where('contract_con_id', $record['con_id'])
                    ->whereMonth('paid_at', $index + 1)
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

        $term = explode(' ', $record->payment_date);
        $day = preg_replace("/[^0-9]/", "", $term[0]);
        count($term) == 3 ? $months = 1 : $months = $term[2];

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
