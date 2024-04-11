<?php

namespace App\Http\Controllers;

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
}
