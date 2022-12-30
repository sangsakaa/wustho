<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Nilaimapel;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


class GuruController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Guru::orderBy('nama_guru');
        if (request('cari')) {
            $data->where('nama_guru', 'like', '%' . request('cari') . '%')->orderby('nama_guru');
            // ->orWhere('Kota_asal', 'like', '%' . request('cari') . '%')
            // ->orWhere('nama_kelas', 'like', '%' . request('cari') . '%')
            // ->orWhere('nis', 'like', '%' . request('cari') . '%')
            // ->orWhere('tanggal_masuk', 'like', '%' . request('cari') . '%')
            // ->orderBy('nis', 'asc');
        }
        return view('guru/guru', ['dataGuru' => $data->paginate(10)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('guru/addGuru');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $guru = new Guru();
        $guru->nama_guru = $request->nama_guru;
        $guru->jenis_kelamin = $request->jenis_kelamin;
        $guru->agama = $request->agama;
        $guru->tempat_lahir = $request->tempat_lahir;
        $guru->tanggal_lahir = $request->tanggal_lahir;
        $guru->tanggal_masuk = $request->tanggal_masuk;
        $guru->save();
        return redirect('guru')->with('success', 'data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
            'guru/detailGuru',
            [
                'guru' => $guru,
                'riwayatMengajar' => $riwayat_mengajara,
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Guru $guru)
    {
        return view('guru/editGuru', ['guru' => $guru]);
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

            ]);
        return redirect('/guru')->with('update', 'pembaharuan data berhasil');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Guru $guru)
    {
        Guru::destroy($guru->id);
        return redirect()->back()->with('delete', 'data guru berhasil dihapus');
    }

}
