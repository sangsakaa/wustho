<?php

namespace App\Livewire;


use Livewire\Component;
use App\Models\Absensiguru;
use App\Models\Kelasmi;
use Illuminate\Support\Facades\DB;

class RekapKelas extends Component
{

    public function render()

    {


        $rekapKelas = Absensiguru::query()
            ->select(
                'kelasmi.nama_kelas',
                DB::raw('COUNT(CASE WHEN absensiguru.keterangan = "hadir" THEN 1 END) as hadir'),
                DB::raw('COUNT(CASE WHEN absensiguru.keterangan = "izin" THEN 1 END) as izin'),
                DB::raw('COUNT(CASE WHEN absensiguru.keterangan = "alfa" THEN 1 END) as alfa'),
                DB::raw('COUNT(CASE WHEN absensiguru.keterangan = "sakit" THEN 1 END) as sakit'),
                // Add this line for total_absensi
                DB::raw('COUNT(DISTINCT sesi_kelas_guru.id) as jumlah_sesi'),
                // Add this line for total_absensi_selain_hadir
                DB::raw('COUNT(DISTINCT sesi_kelas_guru.id) - COUNT(CASE WHEN absensiguru.keterangan = "hadir" THEN 1 END) as total_absensi_selain_hadir')
            )
            ->join('sesi_kelas_guru', 'sesi_kelas_guru.id', 'absensiguru.sesi_kelas_guru_id')
            ->join('kelasmi', 'kelasmi.id', 'sesi_kelas_guru.kelasmi_id')
            ->where('kelasmi.periode_id', session('periode_id'))
            ->groupBy('kelasmi.nama_kelas')
            ->get();
        $rekapKelasGuru = Absensiguru::query()
            ->select(
                'nama_guru',
                'nama_kelas',
                DB::raw('COUNT(CASE WHEN absensiguru.keterangan = "hadir" THEN 1 END) as hadir'),
                DB::raw('COUNT(CASE WHEN absensiguru.keterangan = "izin" THEN 1 END) as izin'),
                DB::raw('COUNT(CASE WHEN absensiguru.keterangan = "alfa" THEN 1 END) as alfa'),
                DB::raw('COUNT(CASE WHEN absensiguru.keterangan = "sakit" THEN 1 END) as sakit'),
                // Add this line for total_absensi
                DB::raw('COUNT(DISTINCT sesi_kelas_guru.id) as jumlah_sesi'),
                // Add this line for total_absensi_selain_hadir
                DB::raw('COUNT(DISTINCT sesi_kelas_guru.id) - COUNT(CASE WHEN absensiguru.keterangan = "hadir" THEN 1 END) as total_absensi_selain_hadir')
            )
            ->join('sesi_kelas_guru', 'sesi_kelas_guru.id', 'absensiguru.sesi_kelas_guru_id')
            ->join('daftar_jadwal', 'daftar_jadwal.id', 'absensiguru.daftar_jadwal_id')
            ->join('guru', 'guru.id', 'daftar_jadwal.guru_id')
            ->join('kelasmi', 'kelasmi.id', 'sesi_kelas_guru.kelasmi_id')
            ->where('kelasmi.periode_id', session('periode_id'))
            ->groupBy('nama_guru', 'nama_kelas')
            ->orderby('nama_kelas')
            ->get();
        // dd($rekapKelasGuru);
        return view(
            'livewire.rekap-kelas',
            [
                'rekapKelas' => $rekapKelas,
                'rekapKelasGuru' => $rekapKelasGuru,


            ]

        );
    }
}
