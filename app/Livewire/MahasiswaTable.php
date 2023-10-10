<?php

namespace App\Livewire;

use App\Models\Siswa;
use Livewire\Component;

class MahasiswaTable extends Component
{
    public $search = ''; // Pastikan variabel ini didefinisikan dengan benar
    public $perPage = 10; // Sesuaikan dengan jumlah per halaman yang diinginkan

    public function render()
    {
        $data = Siswa::search($this->search)
            ->leftJoin('nis', 'nis.siswa_id', '=', 'siswa.id')
            ->select('siswa.*')
            ->paginate($this->perPage);
        return view('livewire.mahasiswa-table', ['data' => $data]);
    }
}
