<?php

namespace App\Livewire;

use App\Models\Asramasiswa;
use App\Models\Pesertaasrama;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ListPesertaAsrama extends Component
{
    public $asramasiswa;
    public $search = '';
    public $selected = [];
    public $selectAll = false;

    public function mount($asramasiswa)
    {
        $this->asramasiswa = $asramasiswa;
    }

    public function render()
    {
        $asramasiswaId = $this->asramasiswa;

        $dataasramasiswa = Asramasiswa::query()
            ->join('asrama', 'asrama.id', '=', 'asramasiswa.asrama_id')
            ->select([
                'asramasiswa.*',
                'asrama.nama_asrama',
            'asrama.type_asrama'
            ])
            ->find($asramasiswaId);

        $data = Pesertaasrama::query()
            ->join('siswa', 'siswa.id', '=', 'pesertaasrama.siswa_id')
            ->join('asramasiswa', 'asramasiswa.id', '=', 'pesertaasrama.asramasiswa_id')
            ->join('asrama', 'asrama.id', '=', 'asramasiswa.asrama_id')
            ->join('nis', 'nis.siswa_id', '=', 'siswa.id')
            ->select([
                'pesertaasrama.id',
                'siswa.nama_siswa',
                'asrama.nama_asrama',
            'asrama.type_asrama',
            'nis.nis',
            'siswa.jenis_kelamin',
            'siswa.kota_asal',
            ])
            ->where('pesertaasrama.asramasiswa_id', $asramasiswaId)

            // GLOBAL SEARCH
            ->when($this->search, function ($query) {
                $search = trim($this->search);

                $query->where(function ($q) use ($search) {
                    $q->where('siswa.nama_siswa', 'like', "%{$search}%")
                        ->orWhere('nis.nis', 'like', "%{$search}%")
                        ->orWhere('siswa.kota_asal', 'like', "%{$search}%")
                        ->orWhere('asrama.nama_asrama', 'like', "%{$search}%")
                        ->orWhere('asrama.type_asrama', 'like', "%{$search}%");
                });
            })

            ->orderBy('siswa.nama_siswa')
            ->get();

        // auto sync selectAll checkbox
        $this->selectAll =
            count($this->selected) === $data->count() && $data->count() > 0;

        return view('livewire.list-peserta-asrama', [
            'asramasiswa' => $asramasiswaId,
            'dataasramasiswa' => $dataasramasiswa,
            'datapeserta' => $data
        ]);
    }

    // HIGHLIGHT SEARCH
    public function highlight($text)
    {
        if (!$this->search) return e($text);

        $text = e($text);

        return preg_replace(
            '/' . preg_quote($this->search, '/') . '/i',
            '<mark class="bg-yellow-200 px-1 rounded">$0</mark>',
            $text
        );
    }
}
