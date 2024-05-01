<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Route_Controller extends Controller
{
    //
    public function Signin()
    {
        if (session()->exists('user') || session()->exists('admin')) {
            return redirect()->back();
        } else {
            return view('signin');
        }
    }
    public function Dashboard()
    {
        if (session()->exists('user') || session()->exists('admin')) {
            return view('dashboard.dashboard');
        } else {
            return redirect('/');
        }
    }

    public function Account()
    {
        if (session()->exists('admin')) {
            return view('account.account');
        } else {
            return view('mode.404');
        }
    }
    public function Contracts()
    {
        if (session()->exists('user') || session()->exists('admin')) {
            return view('contracts.contracts');
        } else {
            return redirect('/');
        }
    }
    public function Notification()
    {
        if (session()->exists('user') || session()->exists('admin')) {
            return view('notification.notification');
        } else {
            return redirect('/');
        }
    }
    public function History()
    {
        if (session()->exists('user') || session()->exists('admin')) {
            return view('contracts.history');
        } else {
            return redirect('/');
        }
    }
    public function Clients()
    {
        if (session()->exists('admin')) {
            return view('partners.clients');
        } else {
            return view('mode.404');
        }
    }
    public function Agents()
    {
        if (session()->exists('admin')) {
            return view('partners.agents');
        } else {
            return view('mode.404');
        }
    }
    public function Coordinators()
    {
        if (session()->exists('admin')) {
            return view('partners.coordinators');
        } else {
            return view('mode.404');
        }
    }
    public function Projects()
    {
        if (session()->exists('user') || session()->exists('admin')) {
            return view('assets.projects');
        } else {
            return view('mode.404');
        }
    }
    public function Buildings()
    {
        if (session()->exists('admin')) {
            return view('assets.buildings');
        } else {
            return view('mode.404');
        }
    }
    public function Units()
    {
        if (session()->exists('admin')) {
            return view('assets.units');
        } else {
            return view('mode.404');
        }
    }
    public function Properties()
    {
        if (session()->exists('user') || session()->exists('admin')) {
            return view('assets.properties');
        } else {
            return redirect('/');
        }
    }
    public function Import()
    {
        if (session()->exists('user') || session()->exists('admin')) {
            return view('file.import');
        } else {
            return redirect('/');
        }
    }
    public function Export()
    {
        if (session()->exists('user') || session()->exists('admin')) {
            return view('file.export');
        } else {
            return redirect('/');
        }
    }
}
