<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\contract;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Dashboard_Controller extends Controller
{
    public function get_data()
    {
        $counts = $this->counts();

        $data = [
            'counts' => $counts,
        ];

        return response()->json($data);
    }

    public function counts()
    {
        $counts = [];

        $counts['clients'] = contract::select('client')->distinct('client')->count();
        $counts['coordinators'] = contract::select('coordinator')->distinct('coordinator')->count();
        $counts['agents'] = contract::select('agent')->distinct('agent')->count();
        $counts['properties'] = contract::select('property')->distinct('property')->count();
        $counts['units'] = contract::select('unit')->count();
        $counts['contracts'] = contract::select('con_id')->whereNot('status', ['Completed'])->count();

        return $counts;
    }

    public function Expiring_Contracts()
    {
        $dates = contract::select('contract_end')->get();
        $today = Carbon::today();
        $expired = [];
        $expiring = [];
        $near = [];

        foreach ($dates as $date) {
            $end = Carbon::parse($date->contract_end)->endOfDay();
            $nearDate = $end->copy()->subMonths(1)->endOfDay();
            $minimumDate = $end->copy()->subDays(7)->endOfDay();

            if ($today <= $minimumDate) {
                $expiring[] = $date->contract_end;
            } else if ($end->lessThan($today)) {
                $expired[] = $date->contract_end;
            } else if ($today > $nearDate) {
                $near[] = $date->contract_end;
            }
        }

        return response()->json(['near' => $near, 'expiring' => $expiring, 'expired' => $expired]);
    }
    public function Dues()
    {
        $dates = contract::select('due_date')->get();
        $today = Carbon::today();
        $passdue = [];
        $remaining = [];

        foreach ($dates as $date) {
            $due = Carbon::parse($date->due_date)->endOfDay();
            if ($today->greaterThan($due)) {
                $passdue[] = $due->toDateString();
            } else if ($today->lessThan($due)) {
                $remaining[] = $due->toDateString();
            }
        }

        return response()->json(['passdue' => $passdue, 'remaining' => $remaining]);
    }
    public function Client_Properties()
    {
        $data =
            contract::select('client', DB::raw('count(unit) as unit_count'))
            ->distinct('client')
            ->groupBy('client')
            ->orderBy('unit_count', 'desc')
            ->limit(7)
            ->get();



        return response()->json($data);
    }
}
