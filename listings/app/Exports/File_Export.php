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
        $contracts = contract::all();

        foreach ($contracts as $contract) {
            $contract['contract_start'] = $this->format_date($contract['contract_start']);
            $contract['contract_end'] = $this->format_date($contract['contract_end']);
            $contract['due_date'] = $this->format_date($contract['due_date']);
        }
        return view('export.export', [
            'contracts' => $contracts
        ]);
    }

    
    public function format_date($date_string) {
        $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

        $date_arr = explode('-', $date_string);
        
        $year = $date_arr[0];
        
        $month = $months[$date_arr[1] - 1];
        
        $day = (int)$date_arr[2];
        
        $date = "$month $day, $year";
        return $date;
    }
}
