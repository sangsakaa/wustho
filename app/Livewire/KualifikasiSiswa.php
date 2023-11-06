<?php

namespace App\Livewire;

use App\Models\Pesertakelas;
use App\Models\Siswa;
use Livewire\Component;

class KualifikasiSiswa extends Component
{
    public function render()
    {
        $dataSiswa = Pesertakelas::query()
            ->join('absensikelas', 'absensikelas.pesertakelas_id', 'pesertakelas.id')
            ->join('siswa', 'pesertakelas.siswa_id', 'siswa.id')
            ->join('nis', 'siswa.id', 'nis.siswa_id')
            ->join('kelasmi', 'pesertakelas.kelasmi_id', 'kelasmi.id')
            ->join('periode', 'kelasmi.periode_id', 'periode.id')
            ->select('siswa.nama_siswa', 'periode.periode', 'nis')
            ->selectRaw('SUM(CASE WHEN absensikelas.keterangan = "hadir" THEN 1 ELSE 0 END) as kehadiran')
            ->groupBy('siswa.nama_siswa', 'periode.periode', 'nis')
            ->orderby('nis.nis')
            ->get();


        return view('livewire.kualifikasi-siswa', ['dataSiswa' => $dataSiswa]);
    }
}
