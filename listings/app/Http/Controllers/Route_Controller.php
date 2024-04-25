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
    public function Buildings()
    {
        return view('assets.buildings');
    }
    public function Units()
    {
        return view('assets.units');
    }
    public function Properties()
    {
        return view('assets.properties');
    }
    public function Import()
    {
        return view('file.import');
    }
    public function Export()
    {
        return view('file.export');
    }
}
