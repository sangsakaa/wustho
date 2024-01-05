<?php

namespace App\Livewire;

use App\Models\Periode;
use Livewire\Component;
use App\Models\Pesertakelas;
use Illuminate\Support\Facades\DB;

class KualifikasiSiswa extends Component
{

    public $angkatan = '2021';
    public function render()
    {
        $periodeKelas = Periode::query()
            ->join('semester', 'semester.id', 'periode.semester_id')
            // ->substr('periode', 0, 4)
            ->get();
        $dataSiswa = Pesertakelas::query()
            ->join('absensikelas', 'absensikelas.pesertakelas_id', 'pesertakelas.id')
            ->join('siswa', 'siswa.id', 'pesertakelas.siswa_id')
            ->join('nis', 'nis.siswa_id', 'siswa.id')
            ->join('kelasmi', 'kelasmi.id', 'pesertakelas.kelasmi_id')
            ->join('periode', 'periode.id', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', 'periode.semester_id')
            // ->where('kelasmi.periode_id', session('periode_id'))
            ->select(
            'ket_semester',
            'nama_siswa',
            'nis',
            'periode',
            DB::raw('COUNT(CASE WHEN keterangan = "alfa" THEN 1 END) as jumlah_alfa'),
            DB::raw('COUNT(CASE WHEN keterangan = "izin" THEN 1 END) as jumlah_izin'),
            DB::raw('COUNT(CASE WHEN keterangan = "sakit" THEN 1 END) as jumlah_sakit'),
            DB::raw('COUNT(CASE WHEN keterangan = "hadir" THEN 1 END) as jumlah_hadir'),
            DB::raw('COUNT(absensikelas.sesikelas_id) as jumlah_sesikelas_id'), // tambahkan jumlah_sesikelas_id
            DB::raw('(COUNT(CASE WHEN keterangan = "hadir" THEN 1 END) / COUNT(absensikelas.sesikelas_id)) * 100 as presentase_hadir'), // hitung presentase hadir
            
        )
            ->groupBy('ket_semester',  'periode', 'nis', 'nama_siswa') // tambahkan sesikelas_id ke dalam grup
            ->where('nis', 'like', '%' . $this->angkatan . '%')
            ->orderBy('nama_siswa')
            ->whereNot('ket_semester', 'pendek')
            ->orderBy('periode')
            // ->limit(1000)
            ->get();
            

        return view(
            'livewire.kualifikasi-siswa',
            [
                'dataSiswa' => $dataSiswa,
                'periodeKelas' => $periodeKelas,
                

            ]
        );
    }
}
