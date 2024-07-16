<?php

namespace App\Http\Controllers;


use App\Models\Siswa;
use App\Imports\SiswaImport;

use App\Exports\LaporanExport;
use App\Exports\TemplateExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;



class ExportController
{
    public function Exports()
    {
        return Excel::download(new LaporanExport, "laporan.now().xlsx");
    }
    // public function collection()
    // {
    //     return Siswa::select('id', 'nama_siswa', 'jenis_kelamin', 'agama', 'tempat_lahir', 'tanggal_lahir', 'kota_asal')->get();
    // }
    public function export()
    {
        return Excel::download(new TemplateExport, 'siswa.xlsx');
    }
    public function importSiswa(Request $request)
    {

        $file = $request->file('file');
        // dd($file->all());

        Excel::import(new SiswaImport, $file);

        return redirect()->back()->with('success', 'Data siswa berhasil diimpor.');
    }
}
