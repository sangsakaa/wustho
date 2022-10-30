<?php

namespace App\Http\Controllers;

use App\Models\Absensikelas;
use App\Models\Kelasmi;
use App\Models\Sesikelas;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SesikelasController
{
    public function index()
    {
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
            ->orderByDesc('sesikelas.tgl')
            ->where('kelasmi.periode_id', session('periode_id'));

        if (request('cari')) {
            $sesikelas->where('tgl', 'like', '%' . request('cari') . '%');
        }

        return view('presensi.kelas.sesikelas', [
            'dataKelasMi' => $dataKelasMi,
            'sesikelas' => $sesikelas->paginate(15),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'tgl' => [
                'required',
                'date',
                'before_or_equal:now',
                Rule::unique('sesikelas')->where(fn ($query) => $query->where('kelasmi_id', $request->kelasmi_id))
            ],
            'kelasmi_id' => 'required',
        ]);
        $sesikelas = new Sesikelas();
        $sesikelas->tgl = $request->tgl;
        $sesikelas->kelasmi_id = $request->kelasmi_id;
        $sesikelas->save();
        return redirect()->back()->with('status', 'Sesi Berhasil ditambahkan');
    }

    public function destroy(Sesikelas $sesikelas)
    {
        Sesikelas::destroy($sesikelas->id);
        Absensikelas::where('sesikelas_id', $sesikelas->id)->delete();
        return redirect()->back()->with('status', 'Sesi Ini sudah berhasil di hapus');
    }
}