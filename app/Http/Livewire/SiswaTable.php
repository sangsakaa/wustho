<?php

namespace App\Http\Livewire;

use App\Models\Siswa;
use Livewire\Component;

class SiswaTable extends Component
{
    public $perPage = 10;
    public $search = '' ?? '';


    public function render()
    {
        $data = Siswa::search($this->search)
            ->leftJoin('nis', 'nis.siswa_id', '=', 'siswa.id')
        ->select('siswa.*',)->get();
            // ->paginate($this->perPage)
        ;
        return view('livewire.siswa-table', ['data' => $data]);
    }
}
