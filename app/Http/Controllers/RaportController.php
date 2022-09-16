<?php

namespace App\Http\Controllers;

use App\Models\Nilai;
use App\Models\Nilaimapel;
use App\Models\Pesertakelas;
use App\Models\Semester;
use App\Models\Siswa;
use Illuminate\Http\Request;

class RaportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Siswa $siswa)
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Pesertakelas $pesertakelas)
    {
        $siswa = Pesertakelas::query()
            ->join('siswa', 'pesertakelas.siswa_id', '=', 'siswa.id')
            ->join('nis', 'nis.siswa_id', '=', 'siswa.id')
            ->join('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
            ->join('kelas', 'kelas.id', '=', 'kelasmi.kelas_id')
            ->join('periode', 'periode.id', '=', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            // ->join('semester', 'semester.id', '=', 'kelasmi.periode_id')
            // ->select('kelas.kelas', 'siswa.nama_siswa', 'periode.periode', 'periode.ket_periode', 'semester.semester')
            ->where('pesertakelas.id', $pesertakelas->id)->first();
        $dataraport = Nilaimapel::query()
            ->join('nilai', 'nilai.nilaimapel_id', '=', 'nilaimapel.id')
            // ->join('siswa', 'siswa.id', '=', 'nilai.siswa_id')
            ->join('mapel', 'mapel.id', '=', 'nilaimapel.mapel_id')
            ->join('guru', 'guru.id', '=', 'nilaimapel.guru_id')
            ->where('nilai.pesertakelas_id', $pesertakelas->id)
            ->get();
        return view(
            'report/report',
            [
                'siswa' => $siswa,
                'data' => $dataraport,
                'nilai' => $siswa,

            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
