<?php

namespace App\Livewire;

use App\Models\Jadwal;
use App\Models\Kelasmi;
use App\Models\Periode;
use Livewire\Component;

class ListJadwalGuru extends Component
{
    public $search = '';
    public $perPage = 6;
    public function render()
    {
        $daftarPeriode = Periode::query()
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->select('periode.id', 'periode.periode', 'semester.semester', 'semester.ket_semester')
            ->orderbY('periode.id', 'desc')->get();
        $daftarKelas = Kelasmi::query()
            ->join('periode', 'periode.id', '=', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->join('kelas', 'kelas.id', '=', 'kelasmi.kelas_id')
            ->select('kelasmi.id', 'kelasmi.nama_kelas', 'periode.periode', 'semester.semester', 'semester.ket_semester')
            ->where('kelasmi.periode_id', session('periode_id'))
            ->orderby('nama_kelas')
            ->get();
        $daftarJadwal = Jadwal::search($this->search)
            
            ->leftjoin('kelasmi', 'kelasmi.id', '=', 'jadwal.kelasmi_id')
            ->join('periode', 'periode.id', '=', 'jadwal.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->leftjoin('daftar_jadwal', 'daftar_jadwal.jadwal_id', '=', 'jadwal.id')
            ->leftjoin('guru', 'guru.id', '=', 'daftar_jadwal.guru_id')
            ->leftjoin('mapel', 'mapel.id', '=', 'daftar_jadwal.mapel_id')
            ->select('jadwal.id', 'hari', 'kelasmi.nama_kelas', 'periode.periode', 'kelasmi.periode_id', 'semester.semester', 'semester.ket_semester', 'guru.nama_guru', 'guru.jenis_kelamin', 'mapel.mapel')
            ->where('kelasmi.periode_id', session('periode_id'))
            ->orderby('kelasmi.nama_kelas')
            ->orderby('kelasmi.nama_kelas')
        ->paginate($this->perPage);
        return view('livewire.list-jadwal-guru', [
            'daftarPeriode' => $daftarPeriode,
            'daftarJadwal' => $daftarJadwal,
            'daftarKelas' => $daftarKelas,
        ]);
    }
}
