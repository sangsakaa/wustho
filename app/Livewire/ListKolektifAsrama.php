<?php

namespace App\Livewire;

use App\Models\Siswa;
use Livewire\Component;
use App\Models\Asramasiswa;
use App\Models\Pesertaasrama;


class ListKolektifAsrama extends Component
{
    public $search = '';
    public $asramasiswa;
    public $jenis_kelamin = 'L';

    public $perPage = 10;



    public function mount($asramasiswa)
    {
        $this->asramasiswa = $asramasiswa;
    }
    public function render()
    {
        // dd($this->asramasiswa);
        $asramasiswa = Asramasiswa::query()
            ->where('asramasiswa.periode_id', session('periode_id'))
            ->find($this->asramasiswa);
        // dd($asramasiswa);
        $kelas = Asramasiswa::query()
            ->join('asrama', 'asrama.id', '=', 'asramasiswa.asrama_id')
            ->select('asrama.nama_asrama', 'asramasiswa.id', 'type_asrama')
            ->where('asramasiswa.periode_id', session('periode_id'))
            ->orderby('type_asrama')
            ->get();
        $pesertaAsramaPeriodeTerpilih = Pesertaasrama::query()
            ->join('asramasiswa', 'asramasiswa.id', '=', 'pesertaasrama.asramasiswa_id')
            ->where('asramasiswa.periode_id', $asramasiswa->periode_id)
            ->select('pesertaasrama.siswa_id');
        $Datasiswa = Siswa::search($this->search)
            ->leftJoin('nis', 'nis.siswa_id', '=', 'siswa.id')
            ->leftJoinSub($pesertaAsramaPeriodeTerpilih, 'peserta_asrama_periode_terpilih', function ($join) {
                $join->on('peserta_asrama_periode_terpilih.siswa_id', '=', 'siswa.id');
            })
            ->where('peserta_asrama_periode_terpilih.siswa_id', null)
            ->whereRaw("DATEDIFF(NOW(), nis.tanggal_masuk) <= 1095") // Maksimal 3 tahun (1095 hari)
            ->select([
                'nis.madrasah_diniyah',
                'siswa.jenis_kelamin',
                'siswa.nama_siswa',
                'siswa.id',
                'nis.nis',
                'nis.tanggal_masuk'
            ])
            ->orderBy('nis.madrasah_diniyah')
            ->orderBy('nis.nis')
            ->orderBy('siswa.jenis_kelamin')
            ->orderBy('siswa.nama_siswa')
        ->paginate($this->perPage)
        ->where('jenis_kelamin', $this->jenis_kelamin);
        return view('livewire.list-kolektif-asrama', [
            'Datasiswa' => $Datasiswa,
            'kelas' => $kelas,
            'asramasiswa' => $asramasiswa

        ]);
    }
}
