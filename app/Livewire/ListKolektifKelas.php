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
    public $kelasmi_id;
    public $search = '';
    public $perPage = 10;
    public $angkatan = '';

    public $selected = [];
    public $selectAll = false;

    public function mount($kelasmi)
    {
        $this->kelasmi = $kelasmi;
        $this->kelasmi_id = $kelasmi;
    }

    // =============================
    // FILTER RESET
    // =============================
    public function updatingSearch()
    {
        $this->resetPage();
        $this->selectAll = false;
    }

    public function updatingPerPage()
    {
        $this->resetPage();
        $this->selectAll = false;
    }

    public function updatingAngkatan()
    {
        $this->resetPage();
        $this->selectAll = false;
    }

    // =============================
    // SELECT ALL (AMAN)
    // =============================
    public function updatedSelectAll($value)
    {
        $ids = $this->getCurrentPageIds();

        if ($value) {
            $this->selected = array_unique(array_merge($this->selected, $ids));
        } else {
            $this->selected = array_diff($this->selected, $ids);
        }
    }

    private function getCurrentPageIds()
    {
        $page = $this->page ?? 1;

        return $this->baseQuery()
            ->select('siswa.id')
            ->orderBy('siswa.nama_siswa')
            ->forPage($page, $this->perPage)
            ->pluck('siswa.id')
            ->toArray();
    }

    // =============================
    // BASE QUERY (FIX TOTAL)
    // =============================
    private function baseQuery()
    {
        $pesertaKelas = Pesertakelas::query()
            ->join('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
            ->where('kelasmi.periode_id', session('periode_id'))
            ->select('pesertakelas.siswa_id');

        return Siswa::query()
            ->join('nis', 'siswa.id', '=', 'nis.siswa_id')
            ->join('pesertaasrama', 'siswa.id', '=', 'pesertaasrama.siswa_id')
            ->join('asramasiswa', 'asramasiswa.id', '=', 'pesertaasrama.asramasiswa_id')
            ->join('asrama', 'asrama.id', '=', 'asramasiswa.asrama_id')
            ->leftJoinSub($pesertaKelas, 'peserta_kelas', function ($join) {
                $join->on('peserta_kelas.siswa_id', '=', 'siswa.id');
            })
            ->whereNull('peserta_kelas.siswa_id')
            ->where('asramasiswa.periode_id', session('periode_id'))

            // 🔍 SEARCH
            ->when($this->search, function ($q) {
                $q->where('siswa.nama_siswa', 'like', '%' . $this->search . '%');
            })

            // 🎓 FILTER ANGKATAN
            ->when($this->angkatan, function ($q) {
                $q->whereYear('nis.tanggal_masuk', $this->angkatan);
            });
    }
    public function storeKolektif()
    {
        $this->validate([
            'kelasmi_id' => 'required',
        ], [
            'kelasmi_id.required' => 'Silakan pilih kelas.',
        ]);

        if (count($this->selected) == 0) {

            session()->flash('error', 'Silakan checklist minimal satu siswa.');

            return;
        }

        foreach ($this->selected as $id) {

            Pesertakelas::firstOrCreate([
                'kelasmi_id' => $this->kelasmi_id,
                'siswa_id'   => $id,
            ]);
        }

        $jumlah = count($this->selected);

        $this->selected = [];
        $this->selectAll = false;

        session()->flash(
            'success',
            "{$jumlah} siswa berhasil dimasukkan ke kelas."
        );

        $this->resetPage();
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

        // 🎓 LIST ANGKATAN
        $listAngkatan = Siswa::query()
            ->join('nis', 'siswa.id', '=', 'nis.siswa_id')
            ->selectRaw('YEAR(nis.tanggal_masuk) as tahun')
            ->distinct()
            ->orderByDesc('tahun')
            ->pluck('tahun');

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
            'kelasmi' => $kelasmi,
            'listAngkatan' => $listAngkatan
        ]);
    }
}
