<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Absensikelas;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function checkin(Request $request)
    {
        $request->merge([
            'keterangan' => ucfirst(strtolower($request->keterangan))
        ]);

        $request->validate([
            'sesikelas_id'    => 'required|exists:sesikelas,id',
            'pesertakelas_id' => 'required|exists:pesertakelas,id',
            'keterangan'      => 'required|in:Hadir,Izin,Sakit,Alfa',
            'alasan'          => 'nullable|string',
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
            'data' => [
                'id'       => $absensi->id,
                'status'   => strtolower($absensi->keterangan),
                'alasan'   => $absensi->alasan,
            ]
        ]);
    }
    // public function checkin(Request $request)
    // {
    //     dd($request->all());
    // }
}
