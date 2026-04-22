<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Nig;
use App\Models\Nilaimapel;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


class GuruController extends Controller
{

    public function index()
    {
        $query = Guru::query()->orderBy('nama_guru');

        if (request('cari')) {
            $query->where('nama_guru', 'like', '%' . request('cari') . '%');
        }

        $dataGuru = $query->paginate(10)->withQueryString();

        $totalGuru = Guru::count();
        $aktif = Guru::where('status', 'Aktif')->count();
        $nonaktif = Guru::where('status', 'Non Aktif')->count();
        $cuti = Guru::where('status', 'Cuti')->count();

        return view('guru.guru', compact(
            'dataGuru',
            'totalGuru',
            'aktif',
            'nonaktif',
            'cuti'
        ));
    }
    
    public function create()
    {
        return view('guru/addGuru');
    }

    
    public function store(Request $request)
    {
        $guru = new Guru();
        $guru->nama_guru = $request->nama_guru;
        $guru->jenis_kelamin = $request->jenis_kelamin;
        $guru->agama = $request->agama;
        $guru->tempat_lahir = $request->tempat_lahir;
        $guru->tanggal_lahir = $request->tanggal_lahir;
        $guru->tanggal_masuk = $request->tanggal_masuk;
        $guru->status = $request->status;
        $guru->save();
        return redirect('guru')->with('success', 'data berhasil ditambahkan');
    }


    public function show(Request $request, Guru $guru)
    {
        $periodeId = $request->get('periode_id') ?? session('periode_id');

        // 🔥 ambil daftar periode untuk filter
        $daftarPeriode = Periode::orderBy('periode', 'desc')->get();

        $riwayatMengajar = Nilaimapel::query()
            ->leftJoin('kelasmi', 'kelasmi.id', '=', 'nilaimapel.kelasmi_id')
            ->leftJoin('periode', 'periode.id', '=', 'kelasmi.periode_id')
            ->leftJoin('semester', 'semester.id', '=', 'periode.semester_id')
            ->leftJoin('kelas', 'kelas.id', '=', 'kelasmi.kelas_id')
            ->leftJoin('mapel', 'mapel.id', '=', 'nilaimapel.mapel_id')
            ->leftJoin('guru', 'guru.id', '=', 'nilaimapel.guru_id')
            ->select([
                'nilaimapel.id',
                'kelasmi.nama_kelas',
                'periode.periode',
                'semester.ket_semester',
                'guru.nama_guru',
                'mapel.mapel',
                'mapel.nama_kitab',
            ])
            ->where('nilaimapel.guru_id', $guru->id)
            ->when($periodeId, function ($q) use ($periodeId) {
                $q->where('kelasmi.periode_id', $periodeId);
            })
            ->orderBy('periode.periode', 'desc')
            ->orderBy('kelasmi.nama_kelas')
            ->get();

        return view('guru.detail', [
            'guru' => $guru,
            'riwayatMengajar' => $riwayatMengajar,
            'daftarPeriode' => $daftarPeriode,
            'periodeAktif' => $periodeId
        ]);
    }

   
    public function edit(Guru $guru)
    {
        return view('guru/edit', ['guru' => $guru]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Guru $guru)
    {
        Guru::where('id', $guru->id)
            ->update([
                'nama_guru' => $request->nama_guru,
                'jenis_kelamin' => $request->jenis_kelamin,
                'agama' => $request->agama,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'tanggal_masuk' => $request->tanggal_masuk,
            'status' => $request->status,
            ]);
        return redirect('/guru')->with('update', 'pembaharuan data berhasil');
    }
    public function destroy(Guru $guru)
    {
        Guru::destroy($guru->id);
        return redirect()->back()->with('delete', 'data guru berhasil dihapus');
    }
    // Nis
    public function NIS(Guru $guru)
    {
        $dataGuru = Guru::find($guru->id)->first();
        $NIG = Nig::where('guru_id', $guru->id)->get();
        return view(
            'guru.nig.index',
            [
                'guru' => $guru,
                'dataGuru' => $dataGuru,
                'dataNIG' => $NIG,
            ]
        );
    }
    public function nisGuru(Request $request)
    {
        $nig = new Nig();
        $nig->nig = $request->nig;
        $nig->guru_id = $request->guru_id;
        $nig->jenjang_id = $request->jenjang_id;
        $nig->save();
        return redirect()->back();
    }
    public function destroyNig(Nig $nig)
    {
        Nig::destroy($nig->id);
        return redirect()->back();
    }

}
