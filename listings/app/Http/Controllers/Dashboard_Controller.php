<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\clients;
use App\Models\coordinators;
use App\Models\agents;
use App\Models\projects;
use App\Models\buildings;
use App\Models\units;

class Dashboard_Controller extends Controller
{
    public function get_data() {
        $counts = $this->counts();
        $units_per_proj = $this->units_per_proj();

        $data = [
            'counts' => $counts,
            'units_per_proj' => $units_per_proj,
        ];

        return response()->json($data);
    }

    public function counts() {
        $counts = [];

        $counts['clients'] = clients::count();
        $counts['coordinators'] = coordinators::count();
        $counts['agents'] = agents::count();
        $counts['projects'] = projects::count();
        $counts['units'] = units::count();

        return $counts;
    }

    public function units_per_proj() {
        $projects = projects::all();

        foreach ($projects as $project) {
            $records = buildings::selectRaw('Count(u_id) As units, building_name')
                            ->join('units', 'buildings.b_id', '=', 'units.buildings_b_id')
                            ->where('projects_id', $project->id)->groupBy('building_name')->get();
                            
            $sum = 0;
            foreach ($records as $record) {
                $sum += $record['units'];
            }
            $project['units'] = $sum;
        }

        return $projects;
    }
}
