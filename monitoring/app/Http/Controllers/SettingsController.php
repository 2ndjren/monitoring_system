<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\change_log;

class SettingsController extends Controller
{
    public function Changelog() {
        $changelog = change_log::orderBy('action_date', 'desc')->get();

        $count = count($changelog);
        if ($count > 0) {
            return response()->json(['status' => 200, 'results' => $count, 'changelog' => $changelog]);
        } else {
            return response()->json(['status' => 400, 'results' => $count, 'message' => 'No results found',]);
        }
    }
}
