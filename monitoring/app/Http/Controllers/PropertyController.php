<?php

namespace App\Http\Controllers;

use App\Models\property_units;
use App\Models\unit_owners;
use App\Models\unit_rentals;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PropertyController extends Controller
{
    //
    public function Create_Unit_Owner(Request $request)
    {
        $rules = [
            'name' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['status' => 400, 'errors' => $validator->errors()]);
        }
        $owner = new unit_owners();
        $id = mt_rand(111111111, 999999999);
        $owner->id = $id;
        $owner->name = $request->name;
        $saved = $owner->save();
        if ($saved) {
            return response()->json(['status' => 200, 'message' => 'New unit owner successfully created.']);
        } else {
            return response()->json(['status' => 400, 'message' => 'Something went wrong, please try again.']);
        }
    }

    public function Create_Unit(Request $request)
    {
        $rules = [
            'unit_no' => 'required',
            'project' => 'required',
            'status' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['status' => 400, 'errors' => $validator->errors()]);
        }
        $owner = new property_units();
        $owner->unit_id = mt_rand(11111111, 99999999);
        $owner->unit_no = $request->unit_no;
        $owner->unit_owner_id = $request->owner_id;
        $owner->project = $request->project;
        $owner->status = $request->status;
        $saved = $owner->save();
        if ($saved) {
            if ($request->status == "Available") {
                return response()->json(['status' => 200, 'message' => 'Unit successfully added yet not occupied.']);
            } else if ($request->status == "Occupied") {
                return response()->json(['status' => 200, 'message' => 'Unit successfully added.']);
            }
        } else {
            return response()->json(['status' => 400, 'message' => 'Something went wrong, please try again.']);
        }
    }


    public function Create_Rentals(Request $request)
    {
        $rules = [
            'rental' => 'required',
            'deposit' => 'required',
            'contract_start' => 'required',
            'contract_end' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['status' => 400, 'errors' => $validator->errors()]);
        }
        $owner = new unit_rentals();
        $owner->rental_id = mt_rand(11111111, 99999999);
        $owner->property_unit_id = $request->u_no;
        $owner->rental = $request->rental;
        $owner->markup = $request->markup;
        $owner->deposit = $request->deposit;
        $owner->contract_start = $request->contract_start;
        $owner->contract_end = $request->contract_end;
        $endDate = Carbon::parse($request->contract_end);
        $owner->to_expired = $endDate->subDays(7);
        $owner->notified = "0";
        $owner->status = "Ongoing";
        $ongoing = unit_rentals::where('status', 'Ongoing')->where('property_unit_id', $request->u_no)->first();
        if ($ongoing) {
            return response()->json(['status' => 400, 'message' => 'Action cannot be taken, currently has ongoing transaction.']);
        } else {
            $saved = $owner->save();
            if ($saved) {
                return response()->json(['status' => 200, 'message' => 'Rent inforamtion successfully created.']);
            } else {

                return response()->json(['status' => 400, 'message' => 'Something went wrong, please try again.']);
            }
        }
    }

    public function Unit_Owners()
    {
        $c = unit_owners::all();
        $asc = unit_owners::orderBy('name', 'asc')->get();
        $desc = unit_owners::orderBy('name', 'desc')->get();
        $count = count($c);
        if ($count > 0) {
            return response()->json(['status' => 200, 'results' => $count, 'asc' => $asc, 'desc' => $desc]);
        } else {
            return response()->json(['status' => 400, 'results' => $count, 'message' => 'No results found',]);
        }
    }
    public function Search_Owners($search)
    {
        $searched = unit_owners::where('name', 'like', '%' . $search . '%')->get();
        $asc = unit_owners::where('name', 'like', '%' . $search . '%')->orderBy('name', 'asc')->get();
        $desc = unit_owners::where('name', 'like', '%' . $search . '%')->orderBy('name', 'desc')->get();
        $count = count($searched);
        if ($count > 0) {
            return response()->json(['status' => 200, 'results' => $count, 'searched' => $searched, 'asc' => $asc, 'desc' => $desc]);
        } else {
            return response()->json(['status' => 400, 'results' => $count, 'message' => 'No results found',]);
        }
    }

    public function Display_Unit_Owners_Data($id)
    {
        $owner = unit_owners::where('id', $id)->first();

        if ($owner) {
            return response()->json(['status' => 200, 'owner_details' => $owner]);
        } else {
            return response()->json(['status' => 400,  'message' => 'Owner cannot be found',]);
        }
    }
    public function Display_Unit_Owners()
    {
        $owner = unit_owners::all();
        $count = count($owner);
        if ($count > 0) {
            return response()->json(['status' => 200, 'unit_owners' => $owner]);
        } else {
            return response()->json(['status' => 400,  'message' => 'No results found',]);
        }
    }
    public function Get_Units_Data($u_id)
    {
        $owner = unit_rentals::where('id', $u_id)->first();

        if ($owner) {
            return response()->json(['status' => 200, 'owner_details' => $owner]);
        } else {
            return response()->json(['status' => 400,  'message' => 'Owner cannot be found',]);
        }
    }

    public function Display_Owner_Units($id)
    {
        $unit_only = property_units::where('unit_owner_id', $id)->get();
        $unit_with_details = property_units::join('unit_rentals', 'property_units.unit_id', '=', 'unit_rentals.property_unit_id')->where('property_units.unit_owner_id', $id)->get();
        $count = count($unit_only);
        if ($count > 0) {
            return response()->json(['status' => 200, 'count' => $count, 'message' => 'No of units ', 'unit_only' => $unit_only, 'unit_with_details' => $unit_with_details]);
        } else {
            return response()->json(['status' => 400, 'count' => $count, 'message' => 'No units found!',]);
        }
    }

    public function Display_Current_Rental($id)
    {
        $ongoing = unit_rentals::where('property_unit_id', $id)->where('status', 'Ongoing')->first();
        if ($ongoing) {
            return response()->json(['status' => 200, 'ongoing' => $ongoing]);
        } else {
            return response()->json(['status' => 400,  'message' => 'No existing transaction.',]);
        }
    }

    public function Edit_Rental_Details($id)
    {
        $ongoing = unit_rentals::where('rental_id', $id)->where('status', 'Ongoing')->first();
        if ($ongoing) {
            return response()->json(['status' => 200, 'ongoing' => $ongoing]);
        } else {
            return response()->json(['status' => 400,  'message' => 'No existing transaction.',]);
        }
    }

    public function Update_Rental_Details(Request $request)
    {
        $ongoing = unit_rentals::where('rental_id', $request->rental_id)->where('status', 'Ongoing')
                    ->update([
                        'rental' => $request->rental,
                        'markup' => $request->markup,
                        'deposit' => $request->deposit,
                        'contract_start' => $request->contract_start,
                        'contract_end' => $request->contract_end,
                    ]);

        if ($ongoing) {
            return response()->json(['status' => 200, 'message' => 'Update Rental Details']);
        } else {
            return response()->json(['status' => 400,  'message' => 'No existing transaction.',]);
        }
    }

    public function Delete_Rental_Details($id)
    {
        $ongoing = unit_rentals::where('rental_id', $id)->where('status', 'Ongoing')->delete();
        if ($ongoing) {
            return response()->json(['status' => 200, 'message' => 'Deleted Rental Details']);
        } else {
            return response()->json(['status' => 400,  'message' => 'No existing transaction.',]);
        }
    }

    public function Delete_Unit_Owner($id) {
        $owner = unit_owners::where('id', $id);
        $owner->delete();
        
        if ($owner) {
            return response(['status' => 200, 'message' => 'Deleted Unit Owner']);
        }
        else {
            return response()->json(['status' => 400,  'message' => 'Please Try Again',]);
        }
    }
}
