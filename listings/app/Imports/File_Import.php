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

            $first = substr($vals['contact'], 0, 1);
            if (ctype_digit($first) == 1 && $first != '0') { $vals['contact'] = '0' . $vals['contact']; }

            $vals['contract_start'] = $this->format_date($vals['contract_start']);
            $vals['contract_end'] = $this->format_date($vals['contract_end']);
            $vals['due_date'] = $this->format_date($vals['due_date']);
            
            $record = new model();

            $keys = ['contact', 'contract_start', 'contract_end', 'payment_term', 'tenant_price', 'owner_income', 'company_income', 'payment_date'];
            foreach ($keys as $key) {
                $record->$key = $vals[$key] ?? null;
            }
    
            $upper_keys = ['location', 'client', 'property_details', 'coordinator', 'agent'];
            foreach ($upper_keys as $key) {
                $record->$key = strtoupper($vals[$key]) ?? null;
            }

            if (isset($vals['payment_term'], $vals['payment_date'], $vals['contract_start'])) {
                $term = str_replace(' ', '', $vals['payment_term']);
                $term = explode('+', $term);
                $adv = intval(preg_replace("/[^0-9]/", "", $term[0]));
        
                $term = str_replace(' ', '', $vals['payment_date']);
                $term = explode('/', $term);
                $day = preg_replace("/[^0-9]/", "", $term[0]);
        
                $inter = strtolower($term[1]);
                if (str_starts_with($inter, 'semi')) {
                    $inter = 6;
                }
                else if (str_starts_with($inter, 'quarter')) {
                    $inter = 4;
                }
                else {
                    $inter = 1;
                }
        
                if (isset($vals['due_date'])) {
                    $paid = Carbon::parse($vals['contract_start'])->addMonths($adv-1)->day($day);
                    $record->due_date = Carbon::parse($vals['contract_start'])->addMonths($adv-1+$inter)->day($day);
                }
                else {
                    $paid = Carbon::parse($vals['due_date'])->subMonths($inter)->day($day);
                    $record->due_date = $vals['due_date'];
                }

                $record->status = '';
                $record->save();

                $months = CarbonPeriod::create($vals['contract_start'], '1 month', $paid);
                foreach($months as $month) { 
                    $related = new related;
        
                    $related->contract_con_id = $record->con_id;
                    $related->paid_at = $month->day($day)->format('Y-m-d');
        
                    $related->save();
                }
            }
            else {
                $record->status = '';
                $record->save();
            }
        }
    }

    public function format_date($date) {
        if ($date == '') {
            $date = null;
        }
        else if (ctype_digit($date) == 1) {
            $date = Date::excelToDateTimeObject($date)->format('Y-m-d');
        }
        else {
            $months = ['january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'september', 'october', 'november', 'december'];
            
            $year = substr($date, strpos($date, ",") + 1);
            
            $month = preg_replace('/[^a-z]/i', '', trim(strtolower($date)));
            $month = array_search($month, $months) + 1;
            
            $day = preg_replace('/[a-z]/i', '', $date);
            $day = trim(explode(',', $day)[0]);

            $date = "$year-$month-$day";
        }

        return $date;
    }
}

