<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\clients;
use App\Models\coordinators;
use App\Models\agents;
use App\Models\projects;
use App\Models\units;

class Dashboard_Controller extends Controller
{
    public function get_data() {
        $counts = [];

        $counts['clients'] = clients::count();
        $counts['coordinators'] = coordinators::count();
        $counts['agents'] = agents::count();
        $counts['projects'] = projects::count();
        $counts['units'] = units::count();

        $data = [
            'counts' => $counts,
        ];

        return response()->json($data);
    }
}
