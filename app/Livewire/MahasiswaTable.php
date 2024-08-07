<?php

namespace App\Livewire;

use App\Models\Siswa;
use Livewire\Component;

class MahasiswaTable extends Component
{
    public $search = ''; // Pastikan variabel ini didefinisikan dengan benar
    public $perPage = 10; // Sesuaikan dengan jumlah per halaman yang diinginkan
    public $sortcolumName = 'nis';
    public $sortDerection = 'asc';

    public function sortby($columName)
    {
        $this->sortDerection = ($this->sortDerection === "asc") ? "desc" : "asc";
        $this->sortcolumName = $columName;
    }
    public function render()
    {
        $data = Siswa::search($this->search)
            ->orderby($this->sortcolumName, $this->sortDerection)
            ->leftJoin('nis', 'nis.siswa_id', '=', 'siswa.id')
            ->select('siswa.*', 'nis')
            ->paginate($this->perPage);
        return view('livewire.mahasiswa-table', ['data' => $data]);
    }

}
