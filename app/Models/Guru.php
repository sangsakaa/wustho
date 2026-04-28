<?php

namespace App\Models;

use App\Models\Nig;
use App\Models\Daftar_Jadwal;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Guru extends Model
{
    use HasFactory;
    protected $table = "guru";
    public function NigTerakhir()
    {

        return $this->hasOne(Nig::class)->latestOfMany();
    }

    public function daftar_jadwal()
    {
        return $this->hasMany(Daftar_Jadwal::class, 'guru_id'); // ✅ WAJIB
    }
}
