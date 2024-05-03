<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

use App\Models\contract As model;
use App\Models\payments As related;

class File_Import implements ToCollection, WithStartRow
{
    public $locations = ['BACOOR', 'MAKATI', 'MANDALUYONG', 'PASAY', 'BGC', 'PASIG', 'PARANAQUE', 'QC'];
    public $index;

    public function __construct(){
        $this->index = 0;
    }

    /**
     * Get the start row for the import.
     *
     * @return int
     */
    public function startRow(): int
    {
        return 4;
    }
    public function collection(Collection $rows)
    {
        $vals['location'] = $this->locations[$this->index];
        $this->index += 1;

        foreach ($rows as $row) {
            $vals['client'] = $row[1];
            $vals['property_details'] = $row[2];
            $vals['coordinator'] = $row[3];
            $vals['contact'] = $row[4];
            $vals['agent'] = $row[5];
            $vals['contract_start'] = $row[6];
            $vals['contract_end'] = $row[7];
            $vals['payment_term'] = $row[8];
            $vals['tenant_price'] = $row[9];
            $vals['owner_income'] = $row[10];
            $vals['company_income'] = $row[11];
            $vals['payment_date'] = $row[12];
            $vals['due_date'] = $row[13];
            $vals['status'] = $row[14];

            $first = substr($vals['contact'], 0, 1);
            if (ctype_digit($first) == 1 && $first != '0') { $vals['contact'] = '0' . $vals['contact']; }

            $vals['contract_start'] = $this->format_date($vals['contract_start']);
            $vals['contract_end'] = $this->format_date($vals['contract_end']);
            $vals['due_date'] = $this->format_date($vals['due_date']);

            if ($vals['status'] == '#VALUE!') { $vals['status'] = null; }
            
            $keys = ['location', 'client', 'property_details', 'coordinator', 'contact', 'agent', 'contract_start', 'contract_end', 'payment_term', 'tenant_price', 'owner_income', 'company_income', 'payment_date', 'due_date', 'status'];

            $record = new model;
            foreach ($keys as $key) {
                $record->$key = $vals[$key] ?? null;
            }
            $record->save();

            if ($record->payment_date != null) {
                $term = str_replace(' ', '', $record->payment_date);
                $term = explode('/', $term);
    
                $day = preg_replace("/[^0-9]/", "", $term[0]);
                $last_pay = Carbon::parse($record->due_date)->subMonths(1)->day($day);
    
                $months = CarbonPeriod::create($record->contract_start, '1 month', $last_pay);
                foreach($months as $month) { 
                    $related = new related;
    
                    $related->contract_con_id = $record->con_id;
                    $related->paid_at = $month->day($day)->format('Y-m-d');
                    
                    $related->save();
                }
            }
        }
    }

    public function format_date($date_string) {
        if ($date_string == '') {
            $date = null;
        }
        else if (ctype_digit($date_string) == 1) {
            $date = Date::excelToDateTimeObject($date_string)->format('Y-m-d');
        }
        else {
            $months = ['january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'september', 'october', 'november', 'december'];
            
            $year = substr($date_string, strpos($date_string, ",") + 1);
            
            $month = preg_replace('/[^a-z]/i', '', trim(strtolower($date_string)));
            $index = array_search($month, $months);
            $month = $index + 1;
            
            $day = preg_replace('/[a-z]/i', '', $date_string);
            $day = trim(explode(',', $day)[0]);

            $date = "$year-$month-$day";
        }

        return $date;
    }
}

