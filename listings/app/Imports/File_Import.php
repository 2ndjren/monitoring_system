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
        $location = 'Makati';
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
            $owner_income = $row[9];
            $company_income = $row[10];
            $payment_date = $row[11];
            $due_date = $row[12];
            $status = $row[13];

            $contract_start = $this->format_date($contract_start);
            $contract_end = $this->format_date($contract_end);
            $due_date = $this->format_date($due_date);

            Contract::create([
                'location' => $location ?? null,
                'client' => $client ?? null,
                'property_details' => $property_details ?? null,
                'coordinator' => $coordinator ?? null,
                'contact' => $contact ?? null,
                'agent' => $agent ?? null,
                'contract_start' => $contract_start ?? null,
                'contract_end' => $contract_end ?? null,
                'payment_term' => $payment_term ?? null,
                'tenant_price' => $tenant_price ?? null,
                'owner_income' => $owner_income ?? null,
                'company_income' => $company_income ?? null,
                'payment_date' => $payment_date ?? null,
                'due_date' => $due_date ?? null,
                'status' => $status ?? null,
            ]);
        }
    }

    public function format_date($date_string) {
        if ($date_string == '') {
            $date = null;
            return $date;
        }
        else if (ctype_digit($date_string) == 1) {
            $date = Date::excelToDateTimeObject($date_string)->format('Y-m-d');
            return $date;
        }
        else {
            $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            
            $year = substr($date_string, strpos($date_string, ",") + 1);
            
            $month = preg_replace('/[^a-z]/i', '', trim($date_string));
            $index = array_search($month, $months);
            $month = $index + 1;
            if (strlen($month) == 1) { $month = '0' . $month; }
            
            $day = preg_replace('/[a-z]/i', '', $date_string);
            $day = trim(explode(',', $day)[0]);
            if (strlen($day) == 1) { $day = '0' . $day; }

            $date = "$year-$month-$day";
            return $date;
        }
    }
}
