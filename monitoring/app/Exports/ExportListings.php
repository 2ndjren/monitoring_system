<?php

namespace App\Exports;

use App\Models\asso_dues;
use App\Models\unit_owners;
use App\Models\unit_rentals;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;

class ExportListings implements FromView, ShouldAutoSize
{
    public function view(): View
    {

        $properties = unit_owners::join('property_units', 'unit_owners.id', '=', 'property_units.unit_owner_id')->get();
        // $data = [];
        foreach ($properties as $property) {
            $rent = unit_rentals::where('property_unit_id', $property->unit_id)->where('status', 'Ongoing')->first();
            $dues = asso_dues::where('rent_id', $rent->rental_id)->orderBy('created_at', 'desc')->first();
            $property['asso_dues'] = $dues;
            $property['rental'] = $rent;
        }
        return view('export_lisitngs', ['properties' => $properties]);
    }


    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $lastRow = $sheet->getHighestRow();
                $lastColumn = $sheet->getHighestColumn();

                for ($row = 2; $row <= $lastRow; $row++) {
                    $mergeStartRow = $row;
                    $mergeEndRow = $row;

                    for ($column = 'A'; $column <= $lastColumn; $column++) {
                        $currentCellValue = $sheet->getCell($column . $row)->getValue();
                        $nextCellValue = $sheet->getCell($column . ($row + 1))->getValue();

                        if ($currentCellValue === $nextCellValue) {
                            $mergeEndRow = $row + 1;
                        } else {
                            if ($mergeEndRow > $mergeStartRow) {
                                $sheet->mergeCells($column . $mergeStartRow . ':' . $column . $mergeEndRow);
                            }
                            $mergeStartRow = $row + 1;
                            $mergeEndRow = $row + 1;
                        }
                    }
                }
            },
        ];
    }
}
