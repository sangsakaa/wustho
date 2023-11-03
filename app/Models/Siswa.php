<?php

namespace App\Models;


use App\Models\Nis;
use App\Models\Pesertakelas;
use App\Models\Pesertaasrama;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Siswa extends Model
{
    use HasFactory;
    protected $table = "siswa";
    



    public function kelasTerakhir()
    {
        return $this->hasOne(Pesertakelas::class)->latestOfMany();
    }
    public function NisTerakhir()
    {
        
        return $this->hasOne(Nis::class)->latestOfMany();
    }
    public function asramaTerkhir()
    {
        return $this->hasOne(Pesertaasrama::class)->latestOfMany();
    }
    public static function search($search)
    {
        // dd($search);
        return empty($search) ? static::query() : static::query()
            ->orWhere('nis', 'like', '%' . $search . '%')
            ->orWhere('nama_siswa', 'like', '%' . $search . '%')
            ->where(function ($query) use ($search) {
                $query->where('asramasiswa.periode_id', session('periode_id')); // tambahkan ini untuk memastikan data sesuai dengan 
            }); 
    }
    
    public function kelasmi()
    {
        return $this->belongsToMany(Kelasmi::class, 'pesertakelas', 'siswa_id', 'kelasmi_id');
    }
    

}
