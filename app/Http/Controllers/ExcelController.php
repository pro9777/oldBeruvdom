<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\exel\ProductExport;
use App\Http\exel\ProductImport;


class ExcelController extends Controller
{
    public function export()
    {
        return Excel::download(new ExportBasic, 'users-'.__FUNCTION__.'.xlsx');
    }

    public function import(Request $request)
    {
        $file = $request->file('file');

        Excel::import(new ProductImport, $file);

        return redirect()->back()->with('success', 'Data imported successfully.');
    }
}
