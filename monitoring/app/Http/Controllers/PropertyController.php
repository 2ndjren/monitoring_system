<?php

namespace App\Http\Controllers;

use App\Exports\ExportListings;
use App\Mail\Send_Mail_To_Expire_Notification;
use App\Models\asso_dues;
use App\Models\notification;
use App\Models\property_units;
use App\Models\unit_owners;
use App\Models\unit_rentals;
use App\Models\users;
use App\Models\change_log;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

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

    public function View_Completed_Contracts($id)
    {
        $completed = unit_rentals::where('property_unit_id', $id)->where('status', 'Completed')->orderBy('completed_on', 'desc')->get();
        $count = count($completed);
        if ($count > 0) {
            return response()->json(['status' => 200, 'completed' => $completed]);
        }
    }

    public function View_Contract_Details($id)
    {
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
            ->join('unit_rentals', 'property_units.unit_id', '=', 'unit_rentals.property_unit_id')->get();

        if ($records) {
            return response()->json(['status' => 200, 'records' => $records]);
        } else {
            return response()->json(['status' => 400,  'message' => 'No existing transaction.',]);
        }
    }

    public function Monitoring()
    {
        // Find ongoing rentals that are not yet notified
        $rentals = unit_rentals::where('status', 'Ongoing')->where('notified', '0')->get();

        if (count($rentals) > 0) {
            // dd($rentals);
            foreach ($rentals as $rent) {
                if ($rent->notified == '0') {
                    $end = Carbon::parse($rent->contract_end);
                    $check_expiry = $end->subDays(7);
                    $today = Carbon::today();
                    $unit_owners = unit_owners::join('property_units', 'unit_owners.id', '=', 'property_units.unit_owner_id')->get();
                    if ($today == $check_expiry) {
                        foreach ($unit_owners as $owner) {
                            if ($owner->unit_id == $rent->property_unit_id) {
                                $rents = unit_rentals::join('property_units', 'unit_rentals.property_unit_id', '=', 'property_units.unit_id')->select('property_units.*', 'unit_rentals.*', 'unit_rentals.status as rent_status')->first();
                                $admins = users::all();
                                // dd($admins);
                                foreach ($admins as $admin) {

                                    $start = Carbon::parse($rent->contract_start);
                                    $end = Carbon::parse($rent->contract_end);

                                    $dues = asso_dues::where('rent_id', $rents->rental_id)->get();
                                    $cont_start = $start->format('F j, Y');
                                    $cont_end = $end->format('F j, Y');
                                    $now = $today->format('F j, Y');
                                    $mail_data = [
                                        'receiver' => $admin->fname,
                                        'project' => $owner->project,
                                        'unit_owner' => $owner->name,
                                        'unit_no' => $owner->unit_no,
                                        'contract_start' => $cont_start,
                                        'contract_end' => $cont_end,
                                        'asso_dues' => $dues,
                                        'rental' => $rents,
                                    ];
                                    $mail_now = Mail::to($admin->email)->send(new Send_Mail_To_Expire_Notification($mail_data));
                                }
                            }
                            else {
                                return response()->json(['status' => 400, 'message' => 'Something went wrong']);
                            }
                        }
                        if ($mail_now) {
                            $notif = new notification();
                            $notif->notif_id = "notif" . mt_rand(11111, 99999);
                            // dd()
                            // dd($cont_end);
                            $notif->content = "The  property with Unit No." . $owner->unit_no . " under the ownership of " . $owner->name . " that resides in " . $owner->project . " is near to expire one week from this day " . $now . " to " . $cont_end . ".";
                            $notif->user_id = $admin->user_id;
                            $notif->status = 'Delivered';
                            $notify = $notif->save();
                            if ($notify) {
                                $updated = unit_rentals::where('rental_id', $rent->rental_id)->update([
                                    'notified' => '1'
                                ]);
                                if ($updated) {
                                    return response()->json(['status' => 200, 'message' => '' . $admin->fname . ' has been successfully notified']);
                                }
                            }
                        } else {
                            return response()->json(['status' => 400, 'message' => 'Something went wrong']);
                        }
                    }
                    else {
                        return response()->json(['status' => 400, 'message' => 'Something went wrong', 'rentals' => $rentals, 'expiry' => $check_expiry]);
                    }
                }
                else {
                    return response()->json(['status' => 400, 'message' => 'Something went wrong']);
                }
            }
        } else {
            return response()->json(['status' => 400, 'message' => 'No ongoing rentals found']);
        }
    }
    public function DownloadListings()
    {
        return Excel::download(new ExportListings, 'listings.xlsx');
    }
}
// $property = property_units::where('unit_id', $rent->property_unit_id)->first();




// if ($property) {
//     // Retrieve owner details
//     $unit_owner = unit_owners::find($property->unit_owner_id);
//     $owner = $unit_owner ? $unit_owner->name : '';

//     // Send notification to each account
//     $accounts = users::all();
//     foreach ($accounts as $account) {
//         $start = Carbon::parse($rent->contract_start);
//         $end = Carbon::parse($rent->contract_end);
//         $cont_start = $start->format('F j, Y');
//         $cont_end = $end->format('F j, Y');

//         $rental = unit_rentals::find($rent->rental_id);
//         $dues = asso_dues::where('rent_id', $rent->rental_id)->get();
//         $mail_data = [
//             'receiver' => $account->fname,
//             'project' => $property->project,
//             'unit_owner' => $owner,
//             'unit_no' => $property->unit_no,
//             'contract_start' => $cont_start,
//             'contract_end' => $cont_end,
//             'asso_dues' => $dues,
//         ];
//         $mail_now = Mail::to($account->email)->send(new Send_Mail_To_Expire_Notification($mail_data));

//         if ($mail_now) {
//             // Update rental status and set as notified
//             $rental->status = '1'; // Assuming '1' means notified
//             $rental->notified = '1';
//             $rental->save();

//             // Create notification record
//             $notif = new notification();
//             $notif->notif_id = "notif" . mt_rand(11111, 99999);
//             if (Session::exists('user')) {
//                 $notif->user_id = Session::get('user')['user_id'];
//             }
//             $notif->status = 'Delivered';
//             $notif->save();
//         } else {
//             return response()->json(['status' => 400, 'message' => 'Something went wrong']);
//         }
//     }
// }