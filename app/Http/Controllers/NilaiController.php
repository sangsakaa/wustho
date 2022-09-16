<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Nilai;
use App\Models\Kelasmi;
use App\Models\Semester;
use App\Models\Nilaimapel;
use App\Models\Pesertakelas;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class NilaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataMapel = Mapel::query()
            ->join('kelas', 'kelas.id', '=', 'mapel.kelas_id')
            ->select('mapel.id', 'mapel.mapel', 'kelas.kelas', 'mapel.nama_kitab')
            ->get();
        $datSmt = Semester::query()
            // ->join('periode', 'periode.id', '=', 'semester.periode_id')
            ->get();
        $dataGuru = Guru::all();
        $dataKelas = Kelasmi::query()
            ->join('periode', 'periode.id', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', 'periode.semester_id')
            ->select('kelasmi.id', 'kelasmi.nama_kelas', 'periode.periode', 'semester.ket_semester')
            ->orderBy('kelasmi.nama_kelas')
            ->get();
        $dataJumlahPeserta = Kelasmi::query()
        ->select(['kelasmi.id', DB::raw('count(pesertakelas.id) as jumlah_peserta_kelas')])
        ->join('pesertakelas', 'pesertakelas.kelasmi_id', '=', 'kelasmi.id')
        ->groupBy('kelasmi.id');
        $data = Nilaimapel::query()
            ->leftjoin('kelasmi', 'kelasmi.id', '=', 'nilaimapel.kelasmi_id')
            ->leftjoin('periode', 'periode.id', '=', 'kelasmi.periode_id')
            ->leftjoin('semester', 'semester.id', '=', 'periode.semester_id')
            ->leftjoin('kelas', 'kelas.id', '=', 'kelasmi.kelas_id')
            ->leftjoin('mapel', 'mapel.id', '=', 'nilaimapel.mapel_id')
            ->leftjoin('guru', 'guru.id', '=', 'nilaimapel.guru_id')
            ->leftjoin('nilai', 'nilai.nilaimapel_id', '=', 'nilaimapel.id')
            ->joinSub(
                $dataJumlahPeserta,
                'datajumlahpeserta',
                function ($join) {
                    $join->on('kelasmi.id', '=', 'datajumlahpeserta.id');
                }
            )
            ->selectRaw('nilaimapel.id, kelas.kelas, nama_kelas, semester.semester, semester.ket_semester, guru.nama_guru, mapel.mapel, kelasmi.periode_id, periode.periode, count(nilai.nilai_harian) as jumlah_nilai_harian, count(nilai.nilai_ujian) as jumlah_nilai_ujian, jumlah_peserta_kelas')
            ->groupBy(
                'nilaimapel.id',
                'kelas.kelas',
                'nama_kelas',
                'semester.semester',
                'semester.ket_semester',
                'guru.nama_guru',
                'mapel.mapel',
                'kelasmi.periode_id',
                'periode.periode',
                'jumlah_peserta_kelas'
            )->orderBy('mapel');
        if (request('cari')) {
            $data->where('nama_kelas', 'like', '%' . request('cari') . '%')
            ->orWhere('ket_semester', 'like', '%' . request('cari') . '%')
            ->orWhere('nama_kelas', 'like', '%' . request('cari') . '%')
            ->orWhere('mapel', 'like', '%' . request('cari') . '%');
        }
        // dd($data);
        return view(
            'nilai/nilaimapel',
            [
                'data' => $data->paginate(6),
                'dataGuru' => $dataGuru,
                'dataKelas' => $dataKelas,
                'dataSmt' => $datSmt,
                'dataMapel' => $dataMapel
            ]
        );
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
           //dd(Nilai::find($request->nilai_id[$request->pesertakelas[1]]));
        foreach ($request->pesertakelas as $peserta) {
            $nilai_id = $request->nilai_id[$peserta];
            $nilai = $nilai_id ? Nilai::find($nilai_id) : new Nilai();
            $nilai->pesertakelas_id = $peserta;
            $nilai->nilaimapel_id = $request->nilaimapel_id;
            $nilai->semester_id = $request->semester_id;
            $nilai->nilai_harian = $request->nilai_harian[$peserta];
            $nilai->nilai_ujian = $request->nilai_ujian[$peserta];
            $nilai->save();
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Nilai  $nilai
     * @return \Illuminate\Http\Response
     */
    public function show(Nilaimapel $nilaimapel)
    {
        $titlenilai = $nilaimapel->query()
            ->join('mapel', 'mapel.id', '=', 'nilaimapel.mapel_id')
            ->join('guru', 'guru.id', '=', 'nilaimapel.guru_id')
            ->join('kelasmi', 'kelasmi.id', '=', 'nilaimapel.kelasmi_id')
            ->join('periode', 'periode.id', '=', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->find($nilaimapel)->first();
        $dataSiswa = Pesertakelas::query()
            ->join('siswa', 'siswa.id', '=', 'pesertakelas.siswa_id')
            ->join('nis', 'siswa.id', '=', 'nis.siswa_id')
            ->join('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
            ->join('kelas', 'kelas.id', '=', 'kelasmi.kelas_id')
            ->join('periode', 'periode.id', '=', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->leftJoin('nilai', function ($join) use ($nilaimapel) {
                $join->on('nilai.pesertakelas_id', '=', 'pesertakelas.id')
                    ->where('nilai.nilaimapel_id', '=', $nilaimapel->id);
            })
            ->where('pesertakelas.kelasmi_id', $nilaimapel->kelasmi_id)
        ->select(
            'pesertakelas.id',
            'siswa.nama_siswa',
            'nis.nis',
            'kelas.kelas',
            'kelasmi.nama_kelas',
            'nilai.nilai_harian',
            'nilai.nilai_ujian',
            'nilai.id as nilai_id'
        )
        ->get();
        return view(
            'nilai/nilai',
            [
                //'listguru' => $guruKelas,
                'dataSiswa' => $dataSiswa,
                'nilaimapel' => $nilaimapel,
                'titlenilai' => $titlenilai

            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Nilai  $nilai
     * @return \Illuminate\Http\Response
     */
    public function edit(Nilai $nilai)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Nilai  $nilai
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Nilai $nilai)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Nilai  $nilai
     * @return \Illuminate\Http\Response
     */
    public function destroy(Nilaimapel $nilaimapel)
    {
        Nilaimapel::destroy($nilaimapel->id);
        Nilai::where('nilaimapel_id', $nilaimapel->id)->delete();
        return  redirect()->back();
    }
    public function storeNilaimapel(Request $request)

    {
        // dd($request);
        $kelas = new Nilaimapel();
        $kelas->kelasmi_id = $request->kelasmi_id;
        $kelas->guru_id = $request->guru_id;
        $kelas->mapel_id = $request->mapel_id;
        $kelas->save();
        return redirect()->back();
    }
}
