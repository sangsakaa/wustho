<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Asramasiswa;
use App\Models\Pesertaasrama;

class ListPesertaAsrama extends Component
{
    public $asramasiswa;
    public $search = '';
    public function mount($asramasiswa)
    {
        // Inisialisasi data kolektif kelas
        $this->asramasiswa = $asramasiswa;
    }
    public function render()
    {
        $asramasiswa = $this->asramasiswa;
        $dataasramasiswa = Asramasiswa::query()
            ->join('asrama', 'asrama.id', 'asramasiswa.asrama_id')
            ->find($this->asramasiswa);
        // dd($asramasiswa);
        $data = Pesertaasrama::search($this->search)
            ->join('siswa', 'siswa.id', '=', 'pesertaasrama.siswa_id')
            ->join('asramasiswa', 'asramasiswa.id', '=', 'pesertaasrama.asramasiswa_id')
            ->join('asrama', 'asrama.id', '=', 'asramasiswa.asrama_id')
            ->join('nis', 'nis.siswa_id', '=', 'siswa.id')
            ->select(
                [
                    'pesertaasrama.id',
                    'siswa.nama_siswa',
                    'asrama.nama_asrama',
                    'nis.nis',
                    'siswa.jenis_kelamin',
                    'siswa.kota_asal',
                    // 'asramasiswa.id'
                ]
            )
            ->where(
                'asramasiswa_id',
                $asramasiswa
            )
            ->orderBy('siswa.nama_siswa')
            ->orderBy('nis.nis')->get();
        return view(
            'livewire.list-peserta-asrama',
            [
                'asramasiswa' => $asramasiswa,
                'dataasramasiswa' => $dataasramasiswa,
                'datapeserta' => $data
            ]
        );
    }
}
