<?php

namespace App\Http\Controllers\Api;

use App\Models\Absensikelas;
use Illuminate\Http\Request;

class AttendanceController
{
    //


    public function checkin(Request $request)
    {
        $request->validate([
            'sesikelas_id'     => 'required|exists:sesikelas,id',
            'pesertakelas_id'  => 'required|exists:pesertakelas,id',
            'keterangan'       => 'required|in:Hadir,Izin,Sakit,Alfa',
            'alasan'           => 'nullable|string',
        ]);

        $absensi = Absensikelas::updateOrCreate(
            [
                'sesikelas_id'    => $request->sesikelas_id,
                'pesertakelas_id' => $request->pesertakelas_id,
            ],
            [
                'keterangan' => $request->keterangan,
                'alasan'     => $request->alasan,
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Presensi berhasil disimpan',
            'data'    => $absensi,
        ]);
    }
}
