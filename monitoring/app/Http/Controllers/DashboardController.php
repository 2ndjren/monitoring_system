<?php

namespace App\Http\Controllers;

use App\Models\asso_dues;
use App\Models\property_units;
use App\Models\unit_owners;
use App\Models\unit_rentals;
use App\Models\users;
use Illuminate\Http\Request;
use SebastianBergmann\CodeCoverage\Report\Xml\Project;

class DashboardController extends Controller
{
    //
    public function Unit_Owners()
    {
        $unit_owners = unit_owners::all();
        $count = count($unit_owners);
        if ($count > 0) {
            return response()->json(['status' => 200, 'unit_owners' => $count]);
        } else {
            return response()->json(['status' => 400, 'unit_owners' => $count]);
        }
    }
    public function Projects()
    {
        $projects = property_units::select('project')->groupBy('project')->get();
        $count = count($projects);
        if ($count > 0) {
            return response()->json(['status' => 200, 'projects' => $count]);
        } else {
            return response()->json(['status' => 400, 'projects' => $count]);
        }
    }
    public function Units()
    {
        $units = property_units::select('unit_no')->orderBy('unit_no', 'asc')->get();
        $count = count($units);
        if ($count > 0) {
            return response()->json(['status' => 200, 'units' => $count]);
        } else {
            return response()->json(['status' => 400, 'units' => $count]);
        }
    }
    public function Available_Units()
    {
        $available = property_units::select('unit_no')->where('status', 'Available')->orderBy('unit_no', 'asc')->get();
        $count = count($available);
        if ($count > 0) {
            return response()->json(['status' => 200, 'available' => $count]);
        } else {
            return response()->json(['status' => 400, 'available' => $count]);
        }
    }
    public function Occupied_Units()
    {
        $occupied = property_units::select('unit_no')->where('status', 'Occupied')->orderBy('unit_no', 'asc')->get();
        $count = count($occupied);
        if ($count > 0) {
            return response()->json(['status' => 200, 'occupied' => $count]);
        } else {
            return response()->json(['status' => 400, 'occupied' => $count]);
        }
    }
    public function Montly_Dues()
    {
        $dues = asso_dues::select('rent_id')->where('status', 'unpaid')->orderBy('rent_id', 'asc')->get();
        $count = count($dues);
        if ($count > 0) {
            return response()->json(['status' => 200, 'dues' => $count]);
        } else {
            return response()->json(['status' => 400, 'dues' => $count]);
        }
    }
    public function Projects_Per_Units()
    {
        $units_per_projects = property_units::selectRaw('project, count(unit_no) as unit_count')
            ->groupBy('project')
            ->orderBy('project')
            ->get();

        $count = count($units_per_projects);
        if ($count > 0) {
            return response()->json(['status' => 200, 'units_per_projects' => $units_per_projects]);
        } else {
            return response()->json(['status' => 400, 'units_per_projects' => $units_per_projects]);
        }
    }
    public function Units_Per_Owner()
    {
        $units_per_owner = unit_owners::join('property_units', 'unit_owners.id', '=', 'property_units.unit_owner_id')
            ->selectRaw('unit_owners.name, count(property_units.unit_no) as unit_count')
            ->groupBy('unit_owners.name')
            ->orderBy('unit_owners.name')
            ->get();


        $count = count($units_per_owner);
        if ($count > 0) {
            return response()->json(['status' => 200, 'units_per_owner' => $units_per_owner]);
        } else {
            return response()->json(['status' => 400, 'units_per_owner' => $units_per_owner]);
        }
    }
    public function Accounts()
    {
        $accounts = users::select('status', 'fname', 'lname')->get();
        $count = count($accounts);
        if ($count > 0) {
            return response()->json(['status' => 200, 'accounts' => $accounts]);
        } else {
            return response()->json(['status' => 400, 'accounts' => $accounts]);
        }
    }
}
