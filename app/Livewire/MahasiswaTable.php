<?php

namespace App\Livewire;

use App\Models\Siswa;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class MahasiswaTable extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $angkatan = '';
    public $sortColumn = 'nama_siswa';
    public $sortDirection = 'asc';

    protected $queryString = [
        'search' => ['except' => ''],
        'angkatan' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingAngkatan()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function sortBy($column)
    {
        $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        $this->sortColumn = $column;
    }

    public function render()
    {
        $query = Siswa::query()
            ->with('nis'); // ✅ gunakan relasi, bukan join

        // 🔎 SEARCH
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('nama_siswa', 'like', '%' . $this->search . '%')
                    ->orWhereHas('nis', function ($q2) {
                        $q2->where('nis', 'like', '%' . $this->search . '%');
                    });
            });
        }

        // 📅 FILTER ANGKATAN
        if ($this->angkatan) {
            $query->whereHas('nis', function ($q) {
                $q->whereYear('tanggal_masuk', $this->angkatan);
            });
        }

        // 📊 SORTING (aman)
        $query->orderBy($this->sortColumn, $this->sortDirection);

        $data = $query->paginate($this->perPage);

        // 📅 LIST ANGKATAN
        $angkatanList = DB::table('nis')
            ->selectRaw('YEAR(tanggal_masuk) as tahun')
            ->whereNotNull('tanggal_masuk')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        return view('livewire.mahasiswa-table', [
            'data' => $data,
            'angkatanList' => $angkatanList,
        ]);
    }
}
