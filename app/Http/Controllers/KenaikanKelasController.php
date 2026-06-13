<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\RiwayatSiswa;
use Illuminate\Http\Request;

class KenaikanKelasController extends Controller
{
    public function index()
    {
        $siswa = Siswa::with('kelas')->get();

        return view('kenaikan.index', compact('siswa'));
    }

    public function proses(Request $request)
    {
        $request->validate([
            'siswa_id'   => 'required',
            'kelas_id'   => 'nullable',
            'periode_id' => 'required',
            'status'     => 'required',
        ]);

        $siswa = Siswa::findOrFail($request->siswa_id);

        // update kelas siswa jika naik kelas
        if ($request->status == 'Naik Kelas') {
            $siswa->kelas_id = $request->kelas_id;
        }

        // update status siswa
        $siswa->status_siswa = $request->status;
        $siswa->save();

        // simpan riwayat
        RiwayatSiswa::create([
            'siswa_id'   => $siswa->id,
            'periode_id' => $request->periode_id,
            'kelas_id'   => $request->kelas_id,
            'status'     => $request->status,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()
            ->back()
            ->with('success', 'Riwayat siswa berhasil disimpan.');
    }
}
