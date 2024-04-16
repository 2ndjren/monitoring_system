<?php

namespace App\Http\Controllers;

use App\Models\asso_dues;
use App\Models\unit_owners;
use App\Models\unit_rentals;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RouteController extends Controller
{
    //


    public function Login()
    {
        if (Session::exists('user')) {
            return redirect()->back();
        } else if ((Session::exists('admin'))) {
            return redirect()->back();
        } else {
            return view('login');
        }
    }
    public function Dashboard()
    {
        if (Session::exists('user')) {
            return view('dashboard.dashboard');
        } else if ((Session::exists('admin'))) {
            return view('dashboard.dashboard');
        } else {
            return view('login');
        }
        return view('dashboard.dashboard');
    }
    public function Unit_Owners()
    {
        if (Session::exists('user')) {
            return view('unit_owners.unit_owners');
        } else if ((Session::exists('admin'))) {
            return view('unit_owners.unit_owners');
        } else {
            return view('login');
        }
    }
    public function View_Owner_Data()
    {
        if (Session::exists('user')) {
            return view('unit_owners.view_owner_data');
        } else if ((Session::exists('admin'))) {
            return view('unit_owners.view_owner_data');
        } else {
            return view('login');
        }
    }
    public function Accounts()
    {
        if (Session::exists('user')) {
            return view('accounts.accounts');
        } else if ((Session::exists('admin'))) {
            return view('accounts.accounts');
        } else {
            return view('login');
        }
    }
    public function Settings()
    {
        if (Session::exists('user')) {
            return view('settings.settings');
        } else if ((Session::exists('admin'))) {
            return view('settings.settings');
        } else {
            return view('login');
        }
    }





    public function TestExport()
    {
        $properties = unit_owners::join('property_units', 'unit_owners.id', '=', 'property_units.unit_owner_id')->get();
        // $data = [];
        foreach ($properties as $property) {
            $rent = unit_rentals::where('property_unit_id', $property->unit_id)->where('status', 'Ongoing')->first();
            $dues = asso_dues::where('rent_id', $rent->rental_id)->orderBy('created_at', 'desc')->first();
            $property['asso_dues'] = $dues;
            $property['rental'] = $rent;
        }
        return view('test.test_export', ['properties' => $properties]);
    }
}
