<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesertaasrama extends Model
{
    use HasFactory;
    protected $table = "pesertaasrama";


    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'asrama_id', 'id');
    }
    public function asramaSiswa()
    {
        return $this->belongsTo(Asramasiswa::class, 'asramasiswa_id', 'id');
    }
    public static function search($search)
    {
        // dd($search);
        return empty($search) ? static::query() : static::query()
            ->orWhere('nama_siswa', 'like', '%' . $search . '%')
            ->whereHas('asramasiswa', function ($query) use ($search) {
                $query->where('periode_id', session('periode_id'));
            });
    }
    
    
}
