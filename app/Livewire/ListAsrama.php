<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Asrama;
use App\Models\Periode;
use App\Models\Asramasiswa;

class ListAsrama extends Component
{
    public $search = '';

    public function render()
    {
        // DATA ASRAMA SISWA (MAIN)
        $dataasrama = Asramasiswa::query()
            ->with(['asrama', 'periode.semester']) // 🔥 pakai relasi
            ->withCount('pesertaasrama') // 🔥 hitung otomatis
            ->when($this->search, function ($query) {
                $query->whereHas('asrama', function ($q) {
                    $q->where('nama_asrama', 'like', "%{$this->search}%")
                        ->orWhere('type_asrama', 'like', "%{$this->search}%");
                });
            })
            ->where('periode_id', session('periode_id'))
            ->orderBy(
                Asrama::select('type_asrama')
                    ->whereColumn('asrama.id', 'asramasiswa.asrama_id')
            )
            ->orderBy(
                Asrama::select('nama_asrama')
                    ->whereColumn('asrama.id', 'asramasiswa.asrama_id')
            )
            ->get();

        // DATA MASTER
        $asrama = Asrama::all();

        $periode = Periode::with('semester')
            ->select('id', 'periode', 'semester_id')
            ->get();

        return view('livewire.list-asrama', [
            'data' => $dataasrama,
            'datasrama' => $asrama,
            'periode' => $periode
        ]);
    }
}
