<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periode extends Model
{
    use HasFactory;
    protected $table = "periode";
    protected $fillable = [
        'periode',
        'semester_id',
        'tanggal_mulai',
        'tahun_hijriyah',
        'is_active', // 🔥 tambahkan ini
    ];

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id');
    }
    public static function getDataPeriode()
    {
        return self::with('semester')
            ->withCount([
                'kelasmi',
                'asramasiswa',
                'lulusan',
                'nominasi'
            ])
            ->get();
    }


    // relasi ke kelasmi
    public function kelasmi()
    {
        return $this->hasMany(Kelasmi::class, 'periode_id');
    }

    // relasi ke asrama siswa
    public function asramasiswa()
    {
        return $this->hasMany(Asramasiswa::class, 'periode_id');
    }

    // kalau ada tabel lain tinggal tambah
    public function lulusan()
    {
        return $this->hasMany(Lulusan::class, 'periode_id');
    }

    public function nominasi()
    {
        return $this->hasMany(Nominasi::class, 'periode_id');
    }
}

