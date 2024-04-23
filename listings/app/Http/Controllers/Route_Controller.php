<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Route_Controller extends Controller
{
    //
    public function Dashboard()
    {
        return view('dashboard.dashboard');
    }
    public function Contracts()
    {
        return view('contracts.contracts');
    }
    public function Clients()
    {
        return view('partners.clients');
    }
    public function Agents()
    {
        return view('partners.agents');
    }
    public function Coordinators()
    {
        return view('partners.coordinators');
    }
    public function Projects()
    {
        return view('assets.projects');
    }
    public function Properties()
    {
        return view('assets.properties');
    }
}
