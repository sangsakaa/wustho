<?php

namespace App\Livewire;

use App\Models\Siswa;
use DB;
use Livewire\Component;
use Livewire\WithPagination;

class MahasiswaTable extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $angkatan = '';
    public $sortcolumName = 'nama_siswa';
    public $sortDerection = 'asc';

    protected $queryString = [
        'search',
        'angkatan'
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingAngkatan()
    {
        $this->resetPage();
    }

    public function sortby($columName)
    {
        $this->sortDerection = $this->sortDerection === 'asc' ? 'desc' : 'asc';
        $this->sortcolumName = $columName;
    }

    public function render()
    {
        $query = Siswa::query()
            ->leftJoin('nis', 'nis.siswa_id', '=', 'siswa.id')
            ->select('siswa.*')

            ->when($this->search, function ($q) {
                $q->where(function ($sub) {
                    $sub->where('siswa.nama_siswa', 'like', '%' . $this->search . '%')
                        ->orWhere('nis.nis', 'like', '%' . $this->search . '%')
                        ->orWhere('siswa.jenis_kelamin', 'like', '%' . $this->search . '%');
                });
            });

        // filter angkatan
        if ($this->angkatan) {
            $query->whereYear('nis.tanggal_masuk', $this->angkatan);
        }

        $data = $query
            ->orderBy($this->sortcolumName, $this->sortDerection)
            ->paginate($this->perPage);

        $angkatanList = \DB::table('nis')
            ->selectRaw('YEAR(tanggal_masuk) as tahun')
            ->whereNotNull('tanggal_masuk')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        return view('livewire.mahasiswa-table', [
            'data' => $data,
            'angkatanList' => $angkatanList
        ]);
    }
}
