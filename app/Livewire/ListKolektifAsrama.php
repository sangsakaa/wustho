<?php

namespace App\Livewire;

use App\Models\Asramasiswa;
use App\Models\Pesertaasrama;
use App\Models\Siswa;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class ListKolektifAsrama extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public $search = '';
    public $asramasiswa;
    public $jenis_kelamin = '';
    public $angkatan = '';
    public $perPage = 10;

    public $selected = [];
    public $selectAll = false;

    public function mount($asramasiswa)
    {
        $this->asramasiswa = $asramasiswa;
    }

    // ✅ RESET PAGINATION
    public function updating($field)
    {
        if (in_array($field, ['search', 'jenis_kelamin', 'angkatan'])) {
            $this->resetPage();
            $this->selected = [];
            $this->selectAll = false;
        }
    }
    public function updatingPerPage()
    {
        $this->resetPage();
        $this->selected = [];
        $this->selectAll = false;
    }

    // ✅ SELECT ALL PER PAGE (FIXED QUERY)
    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selected = $this->getCurrentPageIds();
        } else {
            $this->selected = [];
        }
    }

    // ✅ AMBIL ID SESUAI QUERY YANG SAMA
    private function baseQuery()
    {
        $asramasiswa = Asramasiswa::where('periode_id', session('periode_id'))
            ->findOrFail($this->asramasiswa);

        $pesertaAsrama = Pesertaasrama::join('asramasiswa', 'asramasiswa.id', '=', 'pesertaasrama.asramasiswa_id')
            ->where('asramasiswa.periode_id', $asramasiswa->periode_id)
            ->select('pesertaasrama.siswa_id');

        return Siswa::query()
            ->when(
                $this->search,
                fn($q) =>
                $q->where('siswa.nama_siswa', 'like', '%' . $this->search . '%')
            )
            ->leftJoin('nis', 'nis.siswa_id', '=', 'siswa.id')
            ->leftJoinSub(
                $pesertaAsrama,
                'peserta',
                fn($join) =>
                $join->on('peserta.siswa_id', '=', 'siswa.id')
            )
            ->whereNull('peserta.siswa_id')
            ->whereRaw("DATEDIFF(NOW(), nis.tanggal_masuk) <= 1095")
            ->when(
                $this->jenis_kelamin,
                fn($q) =>
                $q->where('siswa.jenis_kelamin', $this->jenis_kelamin)
            )
            ->when(
                $this->angkatan,
                fn($q) =>
                $q->whereYear('nis.tanggal_masuk', $this->angkatan)
            );
    }

    private function getCurrentPageIds()
    {
        return $this->baseQuery()
            ->select('siswa.id')
            ->forPage($this->page, $this->perPage) // ✅ ini yang benar
            ->pluck('siswa.id')
            ->toArray();
    }

    // ✅ SYNC CHECKBOX HEADER
    public function updatedSelected()
    {
        $this->selectAll = count($this->selected) === count($this->getCurrentPageIds());
    }

    public function render()
    {
        $asramasiswa = Asramasiswa::where('periode_id', session('periode_id'))
            ->findOrFail($this->asramasiswa);

        $kelas = Asramasiswa::join('asrama', 'asrama.id', '=', 'asramasiswa.asrama_id')
            ->select('asrama.nama_asrama', 'asramasiswa.id', 'type_asrama')
            ->where('asramasiswa.periode_id', session('periode_id'))
            ->orderBy('type_asrama')
            ->get();

        $Datasiswa = $this->baseQuery()
            ->select([
            'siswa.id',
            'siswa.nama_siswa',
            'siswa.jenis_kelamin',
                'nis.nis',
            'nis.madrasah_diniyah',
                'nis.tanggal_masuk'
            ])
            ->orderBy('nis.madrasah_diniyah')
            ->orderBy('nis.nis')
            ->orderBy('siswa.nama_siswa')
            ->paginate($this->perPage);

        $angkatanList = DB::table('nis')
            ->selectRaw('YEAR(tanggal_masuk) as tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        return view('livewire.list-kolektif-asrama', [
            'Datasiswa' => $Datasiswa,
            'kelas' => $kelas,
            'asramasiswa' => $asramasiswa,
            'angkatanList' => $angkatanList
        ]);
    }
    public function kolektif()
    {
        if (empty($this->selected)) {
            return;
        }

        foreach ($this->selected as $siswaId) {

            // hindari duplicate
            $exists = \App\Models\Pesertaasrama::where('siswa_id', $siswaId)
                ->where('asramasiswa_id', $this->asramasiswa)
                ->exists();

            if (!$exists) {
                \App\Models\Pesertaasrama::create([
                    'siswa_id' => $siswaId,
                    'asramasiswa_id' => $this->asramasiswa // ✅ BENAR
                ]);
            }
        }

        // reset
        $this->selected = [];
        $this->selectAll = false;

        session()->flash('success', 'Berhasil kolektif ke asrama!');
    }
}
