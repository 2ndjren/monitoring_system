<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RouteController extends Controller
{
    //

    public function Dashboard()
    {
        return view('dashboard.dashboard');
    }
    public function Unit_Owners()
    {
        return view('unit_owners.unit_owners');
    }
    public function View_Owner_Data()
    {
        return view('unit_owners.view_owner_data');
    }
    public function Accounts()
    {
        return view('accounts.accounts');
    }
    public function Settings()
    {
        return view('settings.settings');
    }
}
