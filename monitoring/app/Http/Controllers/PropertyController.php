<?php

namespace App\Http\Controllers;

use App\Models\asso_dues;
use App\Models\property_units;
use App\Models\unit_owners;
use App\Models\unit_rentals;
use App\Models\change_log;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

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
        DB::enableQueryLog();
        $owner = new unit_owners();
        $id = mt_rand(111111111, 999999999);
        $owner->id = $id;
        $owner->name = ucfirst($request->name);
        $saved = $owner->save();
        $query_log = DB::getQueryLog();
        DB::disableQueryLog();

        if ($saved) {
            $action = vsprintf(str_replace(['?'], ['\'%s\''], $query_log[0]['query']), $query_log[0]['bindings']); 
            $change_log = new change_log();
            $change_log->username = Session::get('user')['username'];
            $change_log->action = $action;
            $change_log->save();
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
        $check = property_units::where('project', $request->project)->where('unit_no', $request->unit_no)->first();
        DB::enableQueryLog();
        $owner = new property_units();
        $owner->unit_id = mt_rand(11111111, 99999999);
        $owner->unit_no = $request->unit_no;
        $owner->unit_owner_id = $request->owner_id;
        $owner->project = $request->project;
        $owner->status = $request->status;

        if ($check) {
            return response()->json(['status' => 400, 'message' => 'Unit is already exist']);
        } else {
            $saved = $owner->save();
            $query_log = DB::getQueryLog();
            DB::disableQueryLog();

            if ($saved) {
                $action = vsprintf(str_replace(['?'], ['\'%s\''], $query_log[0]['query']), $query_log[0]['bindings']); 
                $change_log = new change_log();
                $change_log->username = Session::get('user')['username'];
                $change_log->action = $action;
                $change_log->save();

                if ($request->status == "Available") {
                    return response()->json(['status' => 200, 'message' => 'Unit successfully added yet not occupied.']);
                } else if ($request->status == "Occupied") {
                    return response()->json(['status' => 200, 'message' => 'Unit successfully added.']);
                }
            } else {
                return response()->json(['status' => 400, 'message' => 'Something went wrong, please try again.']);
            }
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
        DB::enableQueryLog();
        $owner = new unit_rentals();
        $owner->rental_id = mt_rand(11111111, 99999999);
        $owner->property_unit_id = $request->u_id;
        $owner->rental = $request->rental;
        $owner->markup = $request->markup;
        $owner->deposit = $request->deposit;
        $owner->contract_start = $request->contract_start;
        $owner->contract_end = $request->contract_end;
        $owner->notified = "0";
        $owner->status = "Ongoing";
        $ongoing = unit_rentals::where('status', 'Ongoing')->where('property_unit_id', $request->u_id)->first();
        if ($ongoing) {
            return response()->json(['status' => 400, 'message' => 'Action cannot be taken, currently has ongoing transaction.']);
        } else {
            $property_unit = property_units::where('unit_id', $request->u_id)->update(['status' => 'Occupied']);
            $saved = $owner->save();
            $query_log = DB::getQueryLog();
            DB::disableQueryLog();
            if ($saved) {
                $action = vsprintf(str_replace(['?'], ['\'%s\''], $query_log[2]['query']), $query_log[2]['bindings']); 
                $change_log = new change_log();
                $change_log->username = Session::get('user')['username'];
                $change_log->action = $action;
                $change_log->save();
                $property_unit = property_units::where('unit_no', $request->u_no)
                    ->update([
                        'status' => 'Occupied',
                    ]);
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
            $asso = asso_dues::where('rent_id', $ongoing->rental_id)->where('status', 'Unpaid')->first();
            return response()->json(['status' => 200, 'ongoing' => $ongoing, 'asso' => $asso]);

            // return response()->json(['status' => 200, 'ongoing' => $ongoing, 'asso' => $asso]);
        } else {
            return response()->json(['status' => 400,  'message' => 'No existing transaction.',]);
        }
    }

    public function View_Completed_Contracts($id) {
        $completed = unit_rentals::where('property_unit_id', $id)->where('status', 'Completed')->orderBy('completed_on', 'desc')->get();
        $count = count($completed);
        if ($count > 0) {
            return response()->json(['status' => 200, 'completed' => $completed]);
        }
    }

    public function View_Contract_Details($id) {
        $rental_detail = unit_rentals::where('rental_id', $id)->first();
        $asso_dues = asso_dues::where('rent_id', $id)->orderBy('end', 'desc')->get();

        if ($rental_detail) {
            return response()->json(['status' => 200, 'rental_detail' => $rental_detail, 'asso_dues' => $asso_dues]);
        }
    }

    public function Edit_Rental_Details($id)
    {
        $rental_detail = unit_rentals::where('rental_id', $id)->first();
        if ($rental_detail) {
            return response()->json(['status' => 200, 'rental_detail' => $rental_detail]);
        } else {
            return response()->json(['status' => 400,  'message' => 'No existing transaction.',]);
        }
    }

    public function Update_Rental_Details(Request $request)
    {
        DB::enableQueryLog();
        $ongoing = unit_rentals::where('rental_id', $request->rental_id)->where('status', 'Ongoing')
            ->update([
                'rental' => $request->rental,
                'markup' => $request->markup,
                'deposit' => $request->deposit,
                'contract_start' => $request->contract_start,
                'contract_end' => $request->contract_end,
            ]);
        $query_log = DB::getQueryLog();
        DB::disableQueryLog();

        if ($ongoing) {
            $action = vsprintf(str_replace(['?'], ['\'%s\''], $query_log[0]['query']), $query_log[0]['bindings']); 
            $change_log = new change_log();
            $change_log->username = Session::get('user')['username'];
            $change_log->action = $action;
            $change_log->save();

            return response()->json(['status' => 200, 'message' => 'Update Rental Details']);
        } else {
            return response()->json(['status' => 400,  'message' => 'No changes found.',]);
        }
    }

    public function Delete_Rental_Details($id)
    {
        $find = unit_rentals::where('rental_id', $id)->first();
        $update = property_units::where('unit_id', $find->property_unit_id)->update([
            'status' => 'Available'
        ]);
        if ($update) {
            DB::enableQueryLog();
            $ongoing = unit_rentals::where('rental_id', $id)->where('status', 'Ongoing')->delete();
            $query_log = DB::getQueryLog();
            DB::disableQueryLog();
            if ($ongoing) {
                $action = vsprintf(str_replace(['?'], ['\'%s\''], $query_log[0]['query']), $query_log[0]['bindings']); 
                $change_log = new change_log();
                $change_log->username = Session::get('user')['username'];
                $change_log->action = $action;
                $change_log->save();

                return response()->json(['status' => 200, 'message' => 'Deleted Rental Details']);
            } else {
                return response()->json(['status' => 400,  'message' => 'No existing transaction.',]);
            }
        } else {
            DB::enableQueryLog();
            $ongoing = unit_rentals::where('rental_id', $id)->where('status', 'Ongoing')->delete();
            $query_log = DB::getQueryLog();
            DB::disableQueryLog();
            if ($ongoing) {
                $action = vsprintf(str_replace(['?'], ['\'%s\''], $query_log[0]['query']), $query_log[0]['bindings']); 
                $change_log = new change_log();
                $change_log->username = Session::get('user')['username'];
                $change_log->action = $action;
                $change_log->save();

                return response()->json(['status' => 200, 'message' => 'Deleted Rental Details']);
            } else {
                return response()->json(['status' => 400,  'message' => 'No existing transaction.',]);
            }
        }
    }

    public function End_Transaction_Rental_Details($id)
    {
        $rent = unit_rentals::where('rental_id', $id)->first();
        $property_unit = property_units::where('unit_id', $rent->property_unit_id)->update(['status' => 'Available']);
        if ($property_unit) {

            $rental_details = unit_rentals::where('rental_id', $id)->where('status', 'Ongoing')->update(['status' => 'Completed', 'completed_on' => date("Y-m-d")]);
            if ($rental_details) {
                $dues = asso_dues::where('rent_id', $id)->where('status', 'Unpaid')->first();
                if ($dues) {
                    $update_dues = asso_dues::where('rent_id', $dues->rent_id)->update(['status' => 'Paid']);
                    if ($update_dues) {
                        return response()->json(['status' => 200, 'message' => 'Transaction Completed']);
                    }
                } else {
                    return response()->json(['status' => 200, 'message' => 'Transaction Completed']);
                }
            }
        } else {
            return response()->json(['status' => 400, 'message' => 'Something went wrong']);
        }
    }


    public function Pay_Asso_Dues($id)
    {
        $paid = asso_dues::where('asso_id', $id)->update(['status' => 'Paid']);
        if ($paid) {
            return response()->json(['status' => 200,  'message' => 'Paid successfull',]);
        } else {
            return response()->json(['status' => 400,  'message' => 'Transaction not found',]);
        }
    }

    public function Delete_Unit_Owner($id)
    {
        DB::enableQueryLog();
        $owner = unit_owners::where('id', $id)->delete();
        $query_log = DB::getQueryLog();
        DB::disableQueryLog();

        if ($owner) {
            $action = vsprintf(str_replace(['?'], ['\'%s\''], $query_log[0]['query']), $query_log[0]['bindings']); 
            $change_log = new change_log();
            $change_log->username = Session::get('user')['username'];
            $change_log->action = $action;
            $change_log->save();
            return response(['status' => 200, 'message' => 'Deleted Unit Owner']);
        } else {
            return response()->json(['status' => 400,  'message' => 'Please Try Again',]);
        }
    }
    public function Create_Asso_Dues(Request $request)
    {
        $rules = [
            'start' => 'required',
            'end' => 'required',
            'total' => 'required',
            'status' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['status' => 400, 'errors' => $validator->errors()]);
        }
        $ongoing = unit_rentals::where('rental_id', $request->rental_id)->where('status', 'Ongoing')->first();
        if ($ongoing) {
            DB::enableQueryLog();
            $dues = new asso_dues();
            $dues->asso_id = mt_rand(111111111, 999999999);
            $dues->rent_id = $ongoing->rental_id;
            $dues->start = $request->start;
            $dues->end = $request->end;
            $dues->total = $request->total;
            $dues->status = $request->status;
            $saved = $dues->save();
            $query_log = DB::getQueryLog();
            DB::disableQueryLog();
            if ($saved) {
                $action = vsprintf(str_replace(['?'], ['\'%s\''], $query_log[0]['query']), $query_log[0]['bindings']); 
                $change_log = new change_log();
                $change_log->username = Session::get('user')['username'];
                $change_log->action = $action;
                $change_log->save();
                
                return response()->json(['status' => 200, 'message' => 'Associated monthly dues successfully applied.']);
            } else {
                return response()->json(['status' => 400, 'message' => 'Please try again, something went wrong.']);
            }
        } else {
            return response()->json(['status' => 400, 'message' => 'Sorry, this action cant be used because no existing transaction has been created. Thank you']);
        }
    }

    public function Generate_Report()
    {
        $records = unit_owners::join('property_units', 'unit_owners.id', '=', 'property_units.unit_owner_id')
            ->join('unit_rentals', 'property_units.unit_no', '=', 'unit_rentals.property_unit_id')->get();

        if ($records) {
            return response()->json(['status' => 200, 'records' => $records]);
        } else {
            return response()->json(['status' => 400,  'message' => 'No existing transaction.',]);
        }
    }
    public function Completed_Rental_Transaction($id)
    {
    }
}
