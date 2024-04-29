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

        // $record = new model;

        $keys = ['clients_id', 'projects_id', 'coordinators_id', 'agents_id,contract_start', 'contract_end', 'client_income', 'contract_start', 'contract_end', 'advance', 'deposit', 'tenant_price', 'client_income', 'due_date'];
        $record = new contract();
        foreach ($keys as $key) {
            $record->$key = $request->$key;
        }
        $today = Carbon::today();
        $due = Carbon::parse($request->due_date);

        if ($today > $request->due_date) {
            $pass = $today->diffInDays($due);
            $record->status = $pass . " Days Past Due";
        } else {
            $remaining = $today->diffInDays($due);
            $record->status = $remaining . " Days Remaining";
        }

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
            'agent_fname' => 'required',
            'agent_lname' => 'required',
            'agent_phone' => 'required',
            'agent_email' => 'required|email',
        ]);

        $record = model::find($request->id);
        $keys = ['agent_fname', 'agent_lname', 'agent_phone', 'agent_email'];


        $upd = [];
        foreach ($keys as $key) {
            $upd[$key] = $request->$key;
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
