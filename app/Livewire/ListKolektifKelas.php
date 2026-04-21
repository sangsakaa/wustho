<?php

namespace App\Livewire;

use App\Models\Siswa;
use App\Models\Kelasmi;
use App\Models\Pesertakelas;
use Livewire\Component;
use Livewire\WithPagination;

class ListKolektifKelas extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';


    public $kelasmi;
    public $search = '';
    public $perPage = 10;

    public $selected = [];
    public $selectAll = false;

    public function mount($kelasmi)
    {
        $this->kelasmi = $kelasmi;
    }

    // ✅ reset page saat filter berubah
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    // ✅ select all otomatis (hanya halaman aktif)
    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selected = $this->getCurrentPageIds();
        } else {
            $this->selected = [];
        }
    }

    private function getCurrentPageIds()
    {
        return $this->baseQuery()
            ->pluck('siswa.id')
            ->toArray();
    }

    private function baseQuery()
    {
        $pesertaKelas = Pesertakelas::query()
            ->join('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
            ->where('kelasmi.periode_id', session('periode_id'))
            ->select('pesertakelas.siswa_id');

        return Siswa::query()
            ->when($this->search, function ($q) {
                $q->where('siswa.nama_siswa', 'like', '%' . $this->search . '%');
            })
            ->join('nis', 'siswa.id', '=', 'nis.siswa_id')
            ->join('pesertaasrama', 'siswa.id', '=', 'pesertaasrama.siswa_id')
            ->join('asramasiswa', 'asramasiswa.id', '=', 'pesertaasrama.asramasiswa_id')
            ->join('asrama', 'asrama.id', '=', 'asramasiswa.asrama_id')
            ->leftJoinSub($pesertaKelas, 'peserta_kelas', function ($join) {
                $join->on('peserta_kelas.siswa_id', '=', 'siswa.id');
            })
            ->whereNull('peserta_kelas.siswa_id')
            ->where('asramasiswa.periode_id', session('periode_id'));
    }

    public function render()
    {
        $kelasmi = Kelasmi::find($this->kelasmi);

        $kelas = Kelasmi::query()
            ->join('periode', 'periode.id', '=', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->join('kelas', 'kelas.id', '=', 'kelasmi.kelas_id')
            ->where('kelasmi.periode_id', session('periode_id'))
            ->select(
                'kelasmi.id',
                'nama_kelas',
                'periode.periode',
                'semester.ket_semester'
            )
            ->get();

        $Datasiswa = $this->baseQuery()
            ->select(
                'siswa.id',
                'siswa.nama_siswa',
                'siswa.jenis_kelamin',
                'nis.nis',
                'nis.tanggal_masuk',
                'asrama.nama_asrama'
            )
            ->orderBy('siswa.nama_siswa')
            ->paginate($this->perPage);

        return view('livewire.list-kolektif-kelas', [
            'Datasiswa' => $Datasiswa,
            'kelas' => $kelas,
            'kelasmi' => $kelasmi
        ]);
    }
}
