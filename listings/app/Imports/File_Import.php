<?php

namespace App\Imports;

use App\Models\agents;
use App\Models\contract;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class File_Import implements ToCollection, WithStartRow
{
    /**
     * Get the start row for the import.
     *
     * @return int
     */
    public function startRow(): int
    {
        return 6; // Skip the first 5 rows
    }
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {

            $client = $row[1];
            $property_details = $row[2];
            $coordinator = $row[3];
            $contact = $row[4];
            $agent = $row[5];
            $contract_start = $row[6];
            $contract_end = $row[7];
            $payment_term = $row[8];
            $tenant_price = $row[9];
            $client_income = $row[10];
            $ccompany_income = $row[11];
            $payment_date = $row[12];
            $due_date = $row[13];
            $status = $row[14];
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


    /**
     * Format the date.
     *
     * @param string|null $date
     * @return string|null
     */
    private function formatDate($date)
    {
        // Check if the date is not empty
        if (!empty($date)) {
            // Attempt to parse the date
            $timestamp = strtotime($date);

            // Check if the parsing was successful and the date is not the default UNIX epoch
            if ($timestamp !== false && $timestamp != -1) {
                // Convert the parsed timestamp to 'Y-m-d' format
                return date('Y-m-d', $timestamp);
            } else {
                // Log or handle invalid date values
                // For now, let's return null to skip inserting the invalid date
                return null;
            }
        } else {
            // Handle empty date values
            // For now, let's return null to skip inserting empty dates
            return null;
        }
    }
}
