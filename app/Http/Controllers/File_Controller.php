<?php

namespace App\Http\Controllers;

use App\Exports\File_Export;
use App\Imports\File_Import;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class File_Controller extends Controller
{
    //
    public function Import(Request $request)
    {
        $request->validate([
            'excel_file' => 'required |file',
        ]);
        if (Excel::import(new File_Import, $request->file('excel_file'))) {
            return response()->json(['msg' => 'Imported Successfully']);
        } else {
            return response()->json(['msg' => 'Import failed, Use proper format']);
        }
    }
    public function Export()
    {
        return Excel::download(new File_Export, 'export.xlsx');
    }
}
