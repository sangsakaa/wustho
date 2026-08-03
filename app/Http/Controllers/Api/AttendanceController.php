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
            'session_id'        => 'required|exists:sesikelas,id',
            'peserta_kelas_id'  => 'required|exists:pesertakelas,id',
            'status'            => 'required|in:hadir,izin,sakit,alfa',
            'alasan'            => 'nullable|string',
        ]);

        $absensi = Absensikelas::updateOrCreate(
            [
                'sesikelas_id'    => $request->session_id,
                'pesertakelas_id' => $request->peserta_kelas_id,
            ],
            [
                'keterangan' => ucfirst(strtolower($request->status)),
                'alasan'     => $request->alasan,
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Presensi berhasil disimpan',
            'data' => [
                'id' => $absensi->id,
                'status' => strtolower($absensi->keterangan),
            ]
        ]);
    }
}
