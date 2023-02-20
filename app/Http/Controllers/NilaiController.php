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
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
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
            ->orderBy('kelas.kelas')
            ->orderBy('mapel.mapel')
        ->get();
        $datSmt = Semester::query()
            // ->join('periode', 'periode.id', '=', 'semester.periode_id')
            ->get();
        $dataGuru = Guru::orderBy('nama_guru')->where('status', 'aktif')->get();
        $dataKelas = Kelasmi::query()
            ->join('periode', 'periode.id', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', 'periode.semester_id')
            ->select('kelasmi.id', 'kelasmi.nama_kelas', 'periode.periode', 'semester.ket_semester')
            ->where('kelasmi.periode_id', session('periode_id'))
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
            ->where('kelasmi.periode_id', session('periode_id'))
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
            )
            ->orderBy('nama_kelas');
        if (request('cari')) {
            $data->where(function ($query) {
                $query->where('nama_kelas', 'like', '%' . request('cari') . '%')
                ->orWhere('ket_semester', 'like', '%' . request('cari') . '%')
                ->orWhere('nama_kelas', 'like', '%' . request('cari') . '%')
                ->orWhere('nama_guru', 'like', '%' . request('cari') . '%')
                ->orWhere('mapel', 'like', '%' . request('cari') . '%');});

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
        $titlenilai = Nilaimapel::query()
            ->join('mapel', 'mapel.id', '=', 'nilaimapel.mapel_id')
            ->join('guru', 'guru.id', '=', 'nilaimapel.guru_id')
            ->join('kelasmi', 'kelasmi.id', '=', 'nilaimapel.kelasmi_id')
            ->join('periode', 'periode.id', '=', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->where('nilaimapel.id', $nilaimapel->id)
            ->first();
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
            ->orderby('nama_siswa')->get();
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

    public function nilaipersiswa(Request $request)
    {
        $siswa_id = Auth::user()->siswa_id;
        $user = Siswa::query()
            ->join('nis', 'nis.siswa_id', '=', 'siswa.id')
            ->where('siswa.id', $siswa_id)->first();
        $kelasmiSiswa = Kelasmi::query()
            ->join('pesertakelas', 'pesertakelas.kelasmi_id', '=', 'kelasmi.id')
            ->join('periode', 'periode.id', '=', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', 'periode.semester_id')
            ->where('pesertakelas.siswa_id', $siswa_id)
            ->select('kelasmi.id', 'kelasmi.nama_kelas', 'periode.periode', 'semester.ket_semester');


        $kelasmiTerpilih =
            Kelasmi::query()
            ->join('pesertakelas', 'pesertakelas.kelasmi_id', '=', 'kelasmi.id')
            ->join('periode', 'periode.id', '=', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', 'periode.semester_id')
            ->where('pesertakelas.siswa_id', $siswa_id)
            ->select('kelasmi.id', 'kelasmi.nama_kelas', 'semester.semester', 'periode.periode', 'semester.ket_semester', 'pesertakelas.id as pesertakelas_id')
            ->when($request->kelasmi, function ($query, $kelasmi) {
                $query->where('kelasmi.id', $kelasmi);
            }, function ($query) {
                $query->latest('periode.created_at');
            })
            ->first();
        $dataNilai = Nilaimapel::query()
            ->join('nilai', function ($join) use ($kelasmiTerpilih) {
                $join->on('nilai.nilaimapel_id', '=', 'nilaimapel.id')
                    ->where('nilai.pesertakelas_id', $kelasmiTerpilih->pesertakelas_id);
            })
            ->join('mapel', 'mapel.id', '=', 'nilaimapel.mapel_id')
            ->join('guru', 'guru.id', '=', 'nilaimapel.guru_id')
            ->where('nilaimapel.kelasmi_id', $kelasmiTerpilih->id)
            ->get();
        $title = $kelasmiTerpilih;
        return view('nilai.nilaipersiswa', [
            'kelasmiSiswa' => $kelasmiSiswa->get(),
            'kelasmiTerpilih' => $kelasmiTerpilih,
            'dataNilai' => $dataNilai,
            'title' => $title,
            'user' => $user

        ]);
    }
}
