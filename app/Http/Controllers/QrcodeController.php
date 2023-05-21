<?php

namespace App\Http\Controllers;

use App\Models\Absensikelas;
use Illuminate\Http\Request;

class QrcodeController
{
    public function Scan()
    {
        return view('presensi.asrama.Qrsesiasrama');
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'sesikelas' => 'required',
            'pesertakelas_id' => 'required',
            'keterangan' => 'required'
        ]);

        try {
            Absensikelas::create($data);
            return response()->json(['message' => 'Data absensi kelas berhasil disimpan'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan saat menyimpan data'], 500);
        }
    }
}
