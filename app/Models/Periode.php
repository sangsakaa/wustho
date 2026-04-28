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
        $tahunSekarang = now()->year;
        $batas = $tahunSekarang - 3;

        return self::query()
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->select(
                'periode.id',
                'periode.periode',
                'semester.ket_semester',
                'periode.is_active',
                'periode.tanggal_mulai'
            )
            ->where(function ($query) use ($batas) {
                $query->whereYear('periode.tanggal_mulai', '>=', $batas)
                    ->orWhere('periode.is_active', true);
            })
            // ->orderBy('periode.is_active', 'desc')
            ->orderBy('periode.periode', 'asc')
            ->get();
    }
}

