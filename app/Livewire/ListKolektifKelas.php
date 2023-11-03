<?php

namespace App\Livewire;


use App\Models\Siswa;
use App\Models\Kelasmi;
use Livewire\Component;
use App\Models\Pesertakelas;


class ListKolektifKelas extends Component
{
    public $items = [];
    public $selectAll = false;
    public $kelasmi;
    public $search = '';
    public $perPage = 10;
    public function mount($kelasmi)
    {
        // Inisialisasi data kolektif kelas
        $this->kelasmi = $kelasmi;
    }
    public function render()
    {
        $kelasmi = Kelasmi::find($this->kelasmi);
        $kelas = Kelasmi::query()
            ->join('periode', 'periode.id', '=', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->join('kelas', 'kelas.id', '=', 'kelasmi.kelas_id')
            ->where('kelasmi.periode_id', session('periode_id'))
            ->select('kelasmi.id', 'nama_kelas', 'kelas.kelas', 'kelasmi.kuota', 'periode.periode', 'semester.ket_semester')
            ->get();
        $pesertaKelasPeriodeTerpilih = Pesertakelas::query()
            ->join('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
            ->where('kelasmi.periode_id', session('periode_id'))
            ->select('pesertakelas.siswa_id');
        $Datasiswa = Siswa::search($this->search)
            ->join('nis', 'siswa.id', '=', 'nis.siswa_id')
            ->join('pesertaasrama', 'siswa.id', '=', 'pesertaasrama.siswa_id')
            ->join('asramasiswa', 'asramasiswa.id', '=', 'pesertaasrama.asramasiswa_id')
            ->join('asrama', 'asrama.id', '=', 'asramasiswa.asrama_id')
            ->leftJoinSub($pesertaKelasPeriodeTerpilih, 'peserta_kelas_periode_terpilih', function ($join) {
                $join->on('peserta_kelas_periode_terpilih.siswa_id', '=', 'siswa.id');
            })
            ->where('peserta_kelas_periode_terpilih.siswa_id', null)
            ->where('asramasiswa.periode_id', session('periode_id'))
            ->orderBy('jenis_kelamin')
            ->select('siswa.*', 'nis.nis', 'nis.tanggal_masuk', 'asrama.nama_asrama', 'periode_id')
            ->orderBy('nis')
            ->paginate($this->perPage);
        return view('livewire.list-kolektif-kelas', [
            'Datasiswa' => $Datasiswa,
            'kelas' => $kelas,
            'kelasmi' => $kelasmi
        ]);
    }
    public function addItem()

    {
        // dd($this->items);
        // Logic untuk menambahkan item ke dalam array
        $this->items[] = $this->items;
    }

    public function selectAll()
    {
        $this->selectAll = !$this->selectAll;

        if ($this->selectAll) {
            // Pilih semua item
            $this->items = array_map(function ($item) {
                return true;
            }, $this->items);
        } else {
            // Batal pilih semua item
            $this->items = array_map(function ($item) {
                return false;
            }, $this->items);
        }
    }
}
