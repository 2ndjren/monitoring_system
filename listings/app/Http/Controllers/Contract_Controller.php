<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Models\contract as model;

class Contract_Controller extends Controller
{
    public $ent = 'Contract';

    public function get_all()
    {
        $records = model::all();

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
            'status' => 'required|numeric',
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

        $record->status = "$request->status $request->status_text";

        $record->save();

        return response(['msg' => "Added $this->ent"]);
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
            'status' => 'required|numeric',
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

        $upd['status'] = "$request->status $request->status_text";
 
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
