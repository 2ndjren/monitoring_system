<?php

namespace App\Exports;

use App\Models\contract;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class File_Export implements FromView, ShouldAutoSize
{
    public function view(): View
    {
        return view('export.export', [
            'contracts' => contract::all()
        ]);
    }
}
