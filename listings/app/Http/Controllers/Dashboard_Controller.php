<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\contract;

class Dashboard_Controller extends Controller
{
    public function get_data() {
        $counts = $this->counts();

        $data = [
            'counts' => $counts,
        ];

        return response()->json($data);
    }

    public function counts() {
        $counts = [];

        $counts['clients'] = contract::select('client')->distinct('client')->count();
        $counts['coordinators'] = contract::select('coordinator')->distinct('coordinator')->count();
        $counts['agents'] = contract::select('agent')->distinct('agent')->count();
        $counts['properties'] = contract::select('propert')->distinct('property')->count();
        $counts['units'] = contract::select('unit')->count();
        $counts['contracts'] = contract::select('con_id')->count();

        return $counts;
    }
}