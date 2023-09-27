<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Kelasmi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserguruController
{
    public function DashboardGuru()
    {
        $guru_id = Auth::user()->guru_id;
        $title =  Guru::join('nig', 'guru.id', '=', 'nig.guru_id')
        ->where('guru.id', $guru_id)
            ->first();

        $dataJumlahPeserta = Kelasmi::query()
            ->select(['kelasmi.id', DB::raw('count(pesertakelas.id) as jumlah_peserta_kelas')])
            ->join('pesertakelas', 'pesertakelas.kelasmi_id', '=', 'kelasmi.id')
            ->groupBy('kelasmi.id');
        $guru_id = Auth::user()->guru_id;
        $title =  Guru::join('nig', 'guru.id', '=', 'nig.guru_id')
        ->where('guru.id', $guru_id)
            ->first();
        $mapelGuru = Guru::query()
            ->leftjoin('nig', 'nig.guru_id', '=', 'guru.id')
            ->leftjoin('nilaimapel', 'nilaimapel.guru_id', '=', 'guru.id')
            ->leftjoin('mapel', 'mapel.id', '=', 'nilaimapel.mapel_id')
            ->leftjoin('kelasmi', 'kelasmi.id', '=', 'nilaimapel.kelasmi_id')
            ->leftjoin('kelas', 'kelas.id', '=', 'kelasmi.kelas_id')
            ->join('periode', 'periode.id', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', 'periode.semester_id')
            ->leftjoin('nilai', 'nilai.nilaimapel_id', '=', 'nilaimapel.id')
            ->select([
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
            ])
            ->joinSub(
                $dataJumlahPeserta,
                'datajumlahpeserta',
                function ($join) {
                    $join->on('kelasmi.id', '=', 'datajumlahpeserta.id');
                }
            )
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
            ->selectRaw('nilaimapel.id, kelas.kelas, nama_kelas, semester.semester, semester.ket_semester, guru.nama_guru, mapel.mapel, kelasmi.periode_id, periode.periode, count(nilai.nilai_harian) as jumlah_nilai_harian, count(nilai.nilai_ujian) as jumlah_nilai_ujian, jumlah_peserta_kelas')
            ->where('kelasmi.periode_id', session('periode_id'))
            ->where('guru.id', $guru_id)
            ->orderby('nama_kelas')->get();

        return view('guru.dashboard.gurudashboard', compact('title', 'mapelGuru'));
    }
    public function UserGuru()
    {
        $dataJumlahPeserta = Kelasmi::query()
            ->select(['kelasmi.id', DB::raw('count(pesertakelas.id) as jumlah_peserta_kelas')])
            ->join('pesertakelas', 'pesertakelas.kelasmi_id', '=', 'kelasmi.id')
            ->groupBy('kelasmi.id');
        $guru_id = Auth::user()->guru_id;
        $title =  Guru::join('nig', 'guru.id', '=', 'nig.guru_id')
            ->where('guru.id', $guru_id)
            ->first();
        $userGuru = Guru::query()
            ->leftjoin('nig', 'nig.guru_id', '=', 'guru.id')
            ->leftjoin('nilaimapel', 'nilaimapel.guru_id', '=', 'guru.id')
            ->leftjoin('mapel', 'mapel.id', '=', 'nilaimapel.mapel_id')
            ->leftjoin('kelasmi', 'kelasmi.id', '=', 'nilaimapel.kelasmi_id')
            ->leftjoin('kelas', 'kelas.id', '=', 'kelasmi.kelas_id')
            ->join('periode', 'periode.id', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', 'periode.semester_id')
            ->leftjoin('nilai', 'nilai.nilaimapel_id', '=', 'nilaimapel.id')
            ->select([
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
            ])
            ->joinSub(
                $dataJumlahPeserta,
                'datajumlahpeserta',
                function ($join) {
                    $join->on('kelasmi.id', '=', 'datajumlahpeserta.id');
                }
            )
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
            ->selectRaw('nilaimapel.id, kelas.kelas, nama_kelas, semester.semester, semester.ket_semester, guru.nama_guru, mapel.mapel, kelasmi.periode_id, periode.periode, count(nilai.nilai_harian) as jumlah_nilai_harian, count(nilai.nilai_ujian) as jumlah_nilai_ujian, jumlah_peserta_kelas')
            ->where('kelasmi.periode_id', session('periode_id'))
            ->where('guru.id', $guru_id)
            ->orderby('nama_kelas')->get();
        return view(
            'guru/dashboard/nilaiperguru',
            [
                'dataguru' => $userGuru,
                'title' => $title
            ]
        );
    }
}
