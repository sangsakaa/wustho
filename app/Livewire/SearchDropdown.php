<?php

namespace App\Http\Livewire;

use App\Models\Guru;
use Livewire\Component;

class SearchDropdown extends Component
{
    public $search = '';
    public $results = [];

    public function updatedSearch()
    {
        if (strlen($this->search) > 2) {
            $this->results = Guru::where('nama_guru', 'like', '%' . $this->search . '%')->get(); // Ganti 'name' dengan kolom yang sesuai
        } else {
            $this->results = [];
        }
    }

    public function render()
    {
        return view('livewire.search-dropdown');
    }
}
