<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Pesertakelas;
use Illuminate\Support\Facades\DB;

class KualifikasiSiswa extends Component
{
    public $search = '';
    public $perPage = 6;
    public $Kelas = '';
    public $jenjang = 'Ula';
    public function render()
    {
        $dataSiswa = Pesertakelas::query()
            ->join('absensikelas', 'absensikelas.pesertakelas_id', 'pesertakelas.id')
            ->join('siswa', 'pesertakelas.siswa_id', 'siswa.id')
            ->join('nis', 'siswa.id', 'nis.siswa_id')
            ->join('kelasmi', 'pesertakelas.kelasmi_id', 'kelasmi.id')
            ->join('periode', 'kelasmi.periode_id', 'periode.id')
        ->join('semester', 'semester.id', '=', 'periode.semester_id')
        ->select(
            'siswa.nama_siswa',
            'nama_kelas',
            'keterangan',
            'nis',
            'periode',
            'periode.id',
            'ket_semester',
        )
            ->orderBy('periode.id')
            // ->orderBy('ket_semester')
            // ->limit(20)
            ->where('nama_siswa', 'Zaidatul Inayah')
            ->get();


        return view(
            'livewire.kualifikasi-siswa',
            [
                'dataSiswa' => $dataSiswa,

            ]
        );
    }
}
