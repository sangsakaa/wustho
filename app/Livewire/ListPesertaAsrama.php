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
        $this->asramasiswa = $asramasiswa;
    }

    public function render()
    {
        $asramasiswaId = $this->asramasiswa;

        // 🔹 DATA ASRAMA
        $dataasramasiswa = Asramasiswa::query()
            ->join('asrama', 'asrama.id', '=', 'asramasiswa.asrama_id')
            ->select([
                'asramasiswa.*',
                'asrama.nama_asrama',
                'asrama.type_asrama' // Putra / Putri
            ])
            ->find($asramasiswaId);

        // 🔹 DATA PESERTA
        $data = Pesertaasrama::search($this->search)
            ->join('siswa', 'siswa.id', '=', 'pesertaasrama.siswa_id')
            ->join('asramasiswa', 'asramasiswa.id', '=', 'pesertaasrama.asramasiswa_id')
            ->join('asrama', 'asrama.id', '=', 'asramasiswa.asrama_id')
            ->join('nis', 'nis.siswa_id', '=', 'siswa.id')
            ->select([
                'pesertaasrama.id',
                'siswa.nama_siswa',
                'asrama.nama_asrama',
            'asrama.type_asrama', // Putra / Putri
            'nis.nis',
            'siswa.jenis_kelamin',
            'siswa.kota_asal',
            ])
            ->where('asramasiswa_id', $asramasiswaId)
            ->orderBy('siswa.nama_siswa')
            ->orderBy('nis.nis')
            ->get()
            ->map(function ($item) {

                // 🔹 NORMALISASI DATA
                $typeAsrama = strtolower($item->type_asrama ?? '');
                $jk = strtolower($item->jenis_kelamin);

                // 🔹 DETEKSI SALAH ASRAMA
                $item->salah_asrama =
                    ($typeAsrama === 'putra' && $jk === 'perempuan') ||
                    ($typeAsrama === 'putri' && $jk === 'laki-laki');

                return $item;
            });

        return view('livewire.list-peserta-asrama', [
            'asramasiswa' => $asramasiswaId,
            'dataasramasiswa' => $dataasramasiswa,
            'datapeserta' => $data
        ]);
    }
}
