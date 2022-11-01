<?php

namespace App\Http\Controllers;

use App\Models\Absensikelas;
use App\Models\Kelasmi;
use App\Models\Sesikelas;
use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SesikelasController
{
    public function index(Request $request)
    {
        try {
            $tgl = $request->tgl ? Carbon::parse($request->tgl) : now();
        } catch (InvalidFormatException $ex) {
            $tgl = now();
        }

        $dataKelasMi = Kelasmi::query()
            ->join('periode', 'periode.id', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', 'periode.semester_id')
            ->select('kelasmi.id', 'kelasmi.nama_kelas', 'periode.periode', 'semester.ket_semester')
            ->where('kelasmi.periode_id', session('periode_id'))
            ->orderBy('kelasmi.nama_kelas')
            ->get();

        $sesikelas = Sesikelas::query()
            ->join('kelasmi', 'kelasmi.id', '=', 'sesikelas.kelasmi_id')
            ->join('periode', 'periode.id', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', 'periode.semester_id')
            ->select('sesikelas.*', 'kelasmi.nama_kelas', 'periode.periode', 'semester.ket_semester')
            ->orderBy('kelasmi.nama_kelas')
            ->where('kelasmi.periode_id', session('periode_id'))
            ->where('sesikelas.tgl', $tgl->toDateString())
            ->get();

        return view('presensi.kelas.sesikelas', [
            'dataKelasMi' => $dataKelasMi,
            'sesikelas' => $sesikelas,
            'tgl' => $tgl,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'tgl' => [
                'required',
                'date',
                'before_or_equal:now',
            ],
        ]);

        $dataKelasMi = Kelasmi::query()
            ->where('kelasmi.periode_id', session('periode_id'))
            ->orderBy('kelasmi.nama_kelas')
            ->get();

        $sesikelas = Sesikelas::query()
            ->join('kelasmi', 'kelasmi.id', '=', 'sesikelas.kelasmi_id')
            ->select('sesikelas.*', 'kelasmi.nama_kelas')
            ->orderBy('kelasmi.nama_kelas')
            ->where('kelasmi.periode_id', session('periode_id'))
            ->where('sesikelas.tgl', $request->tgl)
            ->get();

        foreach ($dataKelasMi as $kelasmi) {
            if ($sesikelas->doesntContain('nama_kelas', $kelasmi->nama_kelas)) {
                $sesi = new Sesikelas();
                $sesi->tgl = $request->tgl;
                $sesi->kelasmi_id = $kelasmi->id;
                $sesi->save();
            }
        }

        return redirect()->back()->with('status', 'Sesi Berhasil ditambahkan');
    }

    public function destroy(Sesikelas $sesikelas)
    {
        Sesikelas::destroy($sesikelas->id);
        Absensikelas::where('sesikelas_id', $sesikelas->id)->delete();
        return redirect()->back()->with('status', 'Sesi Ini sudah berhasil di hapus');
    }
}
