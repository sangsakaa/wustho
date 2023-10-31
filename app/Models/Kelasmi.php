<?php

namespace App\Models;

use App\Models\Siswa;
use App\Models\Pesertakelas;
use App\Models\Presensikelas;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kelasmi extends Model
{
    use HasFactory;
    protected $table = "kelasmi";


    public function KelasMi()
    {
        return $this->hasMany(Pesertakelas::class, 'id', 'kelasmi');
    }
    public static function search($search)
    {
        // dd($search);
        return empty($search) ? static::query() : static::query()
            ->where('nama_kelas', 'like', '%' . $search . '%');
    }

    
    

    
}
