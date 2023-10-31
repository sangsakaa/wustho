<?php

namespace App\Livewire;

use App\Models\Kelasmi;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class ListKelas extends Component
{
    public $search = '';
    public function render()
    {

        $dataJumlahPeserta = Kelasmi::query()
            ->select(['kelasmi.id', DB::raw('count(pesertakelas.id) as jumlah_peserta_asrama')])
            ->join('pesertakelas', 'pesertakelas.kelasmi_id', '=', 'kelasmi.id')
            ->groupBy('kelasmi.id');
        $lisKelas = Kelasmi::search($this->search)
            ->join('periode', 'periode.id', '=', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->join('kelas', 'kelas.id', '=', 'kelasmi.kelas_id')
            ->leftjoin('pesertakelas', 'pesertakelas.kelasmi_id', '=', 'kelasmi.id')
            ->leftjoinSub(
                $dataJumlahPeserta,
                'datajumlahpeserta',
                function ($join) {
                    $join->on('kelasmi.id', '=', 'datajumlahpeserta.id');
                }
            )
            ->selectRaw('kelasmi.id,nama_kelas,jenjang,ket_semester,kelas,periode,kuota,count(pesertakelas.siswa_id) as jumlah_nilai_ujian, jumlah_peserta_asrama')
            ->where('kelasmi.periode_id', session('periode_id'))
            ->groupBy(
                'kelasmi.id',
                'nama_kelas',
                'kelas',
                'kuota',
                'ket_semester',
                'periode',
                'jumlah_peserta_asrama',
                'jenjang'
            )
            ->orderBy('periode')
            ->orderBy('ket_semester')
            ->orderBy('nama_kelas')
            ->get();

        return view('livewire.list-kelas', ['listkelas' => $lisKelas]);
    }
}
