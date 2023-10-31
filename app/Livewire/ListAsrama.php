<?php

namespace App\Livewire;

use App\Models\Asrama;
use App\Models\Periode;
use Livewire\Component;
use App\Models\Asramasiswa;
use Illuminate\Support\Facades\DB;

class ListAsrama extends Component
{
    public $search = '';
    public function render()
    {
        $dataJumlahPeserta = Asramasiswa::query()
            ->select(['asramasiswa.id', DB::raw('count(pesertaasrama.id) as jumlah_peserta_asrama')])
            ->join('pesertaasrama', 'pesertaasrama.asramasiswa_id', '=', 'asramasiswa.id')
            ->groupBy('asramasiswa.id');
        $asrama = Asrama::all();
        $periode = Periode::query()
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->select('periode.id', 'ket_semester', 'periode.periode')
            ->get();
        $dataasrama = Asramasiswa::search($this->search)
            ->leftjoin('asrama', 'asrama.id', '=', 'asramasiswa.asrama_id')
            ->leftjoin('periode', 'periode.id', '=', 'asramasiswa.periode_id')
            ->leftjoin('semester', 'semester.id', '=', 'periode.semester_id')
            ->leftjoin('pesertaasrama', 'pesertaasrama.asramasiswa_id', '=', 'asramasiswa.id')
            ->leftjoinSub(
                $dataJumlahPeserta,
                'datajumlahpeserta',
                function ($join) {
                    $join->on('asramasiswa.id', '=', 'datajumlahpeserta.id');
                }
            )
            ->selectRaw('asramasiswa.id,nama_asrama,ket_semester,periode,type_asrama,kuota,count(pesertaasrama.siswa_id) as jumlah_nilai_ujian, jumlah_peserta_asrama')
            ->where('asramasiswa.periode_id', session('periode_id'))
            ->groupBy(
                'asramasiswa.id',
                'periode',
                'ket_semester',
                'nama_asrama',
                'type_asrama',
                'kuota',
                'jumlah_peserta_asrama'
            )
            ->orderBy('type_asrama')
            ->orderBy('nama_asrama')
            ->get();
        return view(
            'livewire.list-asrama',
            [
                'data' => $dataasrama,
                'datasrama' => $asrama,
                'periode' => $periode
            ]
        );
    }
}
