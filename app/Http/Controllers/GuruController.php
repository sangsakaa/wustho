<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Nig;
use App\Models\Nilaimapel;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


class GuruController extends Controller
{
    
    public function index()
    {
        $data = Guru::orderBy('nama_guru');
        if (request('cari')) {
            $data->where('nama_guru', 'like', '%' . request('cari') . '%')->orderby('nama_guru');
        }
        return view('guru/guru', ['dataGuru' => $data->paginate(10)]);
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

    
    public function show(Guru $guru)
    {
        $riwayat_mengajara = Nilaimapel::query()
            ->leftjoin('kelasmi', 'kelasmi.id', '=', 'nilaimapel.kelasmi_id')
            ->leftjoin('periode', 'periode.id', '=', 'kelasmi.periode_id')
            ->leftjoin('semester', 'semester.id', '=', 'periode.semester_id')
            ->leftjoin('kelas', 'kelas.id', '=', 'kelasmi.kelas_id')
            ->leftjoin('mapel', 'mapel.id', '=', 'nilaimapel.mapel_id')
            ->leftjoin('guru', 'guru.id', '=', 'nilaimapel.guru_id')
            // ->leftjoin('nilai', 'nilai.nilaimapel_id', '=', 'nilaimapel.id')
            ->selectRaw('nilaimapel.id, kelas.kelas, nama_kelas, semester.semester, semester.ket_semester, guru.nama_guru, mapel.mapel,mapel.nama_kitab, kelasmi.periode_id, periode.periode,nilaimapel.guru_id')
            ->where('nilaimapel.guru_id', $guru->id, session('periode_id'))
            ->where('kelasmi.periode_id', session('periode_id'))
            ->orderBy('nama_kelas')
            ->get();
        return view(
            'guru/detail',
            [
                'guru' => $guru,
                'riwayatMengajar' => $riwayat_mengajara,
            ]
        );
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
