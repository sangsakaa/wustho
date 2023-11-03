<?php

namespace App\Livewire;

use App\Models\Kelasmi;
use Livewire\Component;
use App\Models\Pesertakelas;

class ListPesertaKelas extends Component
{
    public $search = '';
    public $kelasmi;
    public function mount($kelasmi)
    {
        // Inisialisasi data kolektif kelas
        $this->kelasmi = $kelasmi;
    }
    public function render()
    {
        $kelasmi = Kelasmi::find($this->kelasmi);
        $anggota = Pesertakelas::where('kelasmi_id', $this->kelasmi)

            ->count('kelasmi_id');
        $lk = Pesertakelas::where('kelasmi_id', $this->kelasmi)
            ->join('siswa', 'siswa.id', '=', 'pesertakelas.siswa_id')
            ->where('jenis_kelamin', 'L')
            ->count('kelasmi_id');

        $pr = Pesertakelas::where('kelasmi_id', $this->kelasmi)
            ->join('siswa', 'siswa.id', '=', 'pesertakelas.siswa_id')
            ->where('jenis_kelamin', 'P')
            ->count('kelasmi_id');

        $datakelasmi = Kelasmi::query()
            ->join('kelas', 'kelas.id', '=', 'kelasmi.kelas_id')
            ->join('periode', 'kelasmi.periode_id', '=', 'periode.id')
            ->join('semester', 'periode.semester_id', '=', 'semester.id')
            ->select('kelasmi.id', 'kelasmi.nama_kelas', 'kelasmi.kuota', 'periode.periode', 'semester.ket_semester')
            ->where('kelasmi.id', $this->kelasmi)->first();
        $dataKelas = Pesertakelas::search($this->search)
            ->join('siswa', 'siswa.id', '=', 'pesertakelas.siswa_id')
            ->join('nis', 'nis.siswa_id', '=', 'siswa.id')
            ->join('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
            ->join('kelas', 'kelas.id', '=', 'kelasmi.kelas_id')
            ->select('siswa.nama_siswa', 'nis.nis', 'siswa.kota_asal', 'pesertakelas.id', 'siswa.jenis_kelamin', 'kelas.kelas', 'kelasmi.nama_kelas')
            ->where('pesertakelas.kelasmi_id', $this->kelasmi)
            ->orderby('nama_siswa')->get();
        return view('livewire.list-peserta-kelas', [
            'dataKelas' => $dataKelas,
            'datakelasmi' => $datakelasmi,
            'kelasmi' => $kelasmi,
            'hitung' => $anggota,
            'lk' => $lk,
            'pr' => $pr
        ]);
    }
}
