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
            'periode.periode',
            'nis',
            'nama_kelas',
            'keterangan',
            'periode',
            'ket_semester',
            DB::raw('COUNT(absensikelas.keterangan) as total_hadir') // Add this line to count attendances
        )
            ->groupBy('ket_semester', 'siswa.nama_siswa', 'periode.periode', 'nis', 'nama_kelas', 'periode', 'keterangan')
            ->orderBy('nis.nis')
            // ->limit(20)
            ->get();


        return view(
            'livewire.kualifikasi-siswa',
            [
                'dataSiswa' => $dataSiswa,

            ]
        );
    }
}
