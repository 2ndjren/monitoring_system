<?php

namespace App\Imports;

use App\Models\agents;
use App\Models\contract;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class File_Import implements ToCollection, WithStartRow
{
    /**
     * Get the start row for the import.
     *
     * @return int
     */
    public function startRow(): int
    {
        return 2;
    }
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {

            $client = $row[0];
            $property_details = $row[1];
            $coordinator = $row[2];
            $contact = $row[3];
            $agent = $row[4];
            $contract_start = $row[5];
            $contract_end = $row[6];
            $payment_term = $row[7];
            $tenant_price = $row[8];
            $client_income = $row[9];
            $ccompany_income = $row[10];
            $payment_date = $row[11];
            $due_date = $row[12];
            $status = $row[13];

            $contract_start = $this->format_date($contract_start);
            $contract_end = $this->format_date($contract_end);
            $due_date = $this->format_date($due_date);

            Contract::create([
                'client' => $client ?? '-',
                'property_details' => $property_details ?? '-',
                'coordinator' => $coordinator ?? '-',
                'contact' => $contact ?? '-',
                'agent' => $agent ?? '-',
                'contract_start' => $contract_start ?? '-',
                'contract_end' => $contract_end ?? '-',
                'payment_term' => $payment_term ?? '-',
                'tenant_price' => $tenant_price ?? '-',
                'client_income' => $client_income ?? '-',
                'company_income' => $ccompany_income ?? '-',
                'payment_date' => $payment_date ?? '-',
                'due_date' => $due_date ?? '-',
                'status' => $status ?? '-',
            ]);
        }
    }

    public function format_date($date_string) {
        $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

        $date_arr = explode(' ', $date_string);
        
        $year = $date_arr[2];

        $index = array_search($date_arr[0], $months);
        $month = $index + 1;
        if (strlen($month) == 1) { $month = '0' . $month; }

        $day = str_replace(',', '', $date_arr[1]);
        if (strlen($day) == 1) { $day = '0' . $day; }

        $date = "$year-$month-$day";
        return $date;
    }
}
