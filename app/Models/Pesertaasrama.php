<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesertaasrama extends Model
{
    use HasFactory;
    protected $table = "pesertaasrama";
    protected $fillable = ['siswa_id', 'asramasiswa_id'];



    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'asrama_id', 'id');
    }
    public function asramaSiswa()
    {
        return $this->belongsTo(Asramasiswa::class, 'asramasiswa_id', 'id');
    }
    public function pesertaasrama()
    {
        return $this->hasMany(Pesertaasrama::class, 'asramasiswa_id');
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
    public function scopeSearch($query, $keyword)
    {
        return $query->where(function ($q) use ($keyword) {
            $q->where('siswa.nama_siswa', 'like', "%{$keyword}%")
                ->orWhere('siswa.nis', 'like', "%{$keyword}%")
                ->orWhere('siswa.kota_asal', 'like', "%{$keyword}%")
                ->orWhere('asrama.nama_asrama', 'like', "%{$keyword}%");
        });
    }
    
    
}
