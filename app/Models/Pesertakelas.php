<?php

namespace App\Models;

use App\Models\Absensikelas;
use App\Models\Kelasmi;
use App\Models\Siswa;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesertakelas extends Model
{
    use HasFactory;
    protected $table = "pesertakelas";
    protected $fillable = ['siswa_id', 'kelasmi_id'];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id', 'id');
    }
    public function kelasmi()
    {
        return $this->belongsTo(Kelasmi::class, 'kelasmi_id');
    }

    public static function search($search)
    {
        // dd($search);
        return empty($search) ? static::query() : static::query()
            ->orWhere('nis', 'like', '%' . $search . '%')
            ->orWhere('nama_siswa', 'like', '%' . $search . '%')
            ->whereHas('kelasmi', function ($query) use ($search) {
                $query->where('periode_id', session('periode_id'));
            });
    }
    public function absensikelas()
    {
        return $this->hasMany(Absensikelas::class, 'pesertakelas_id', 'id');
    }

    
}
