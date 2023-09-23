<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\LaporanExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportController
{
    public function Exports()
    {
        return Excel::download(new LaporanExport, "laporan.now().xlsx");
    }
}
