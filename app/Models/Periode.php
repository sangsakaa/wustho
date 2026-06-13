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
    protected $casts = [
        'is_active' => 'boolean',
        'tanggal_mulai' => 'date',
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
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    protected static function booted()
    {
        static::saving(function ($model) {

            if ($model->is_active) {

                self::where('id', '!=', $model->id)
                    ->update([
                        'is_active' => false
                    ]);
            }
        });
    }
    public static function getNavbarPeriode()
    {
        return self::with('semester')
            ->select([
                'id',
                'periode',
                'semester_id',
                'is_active'
            ])
            ->get();
    }
}

