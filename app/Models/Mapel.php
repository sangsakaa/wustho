<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    use HasFactory;
    protected $table = "mapel";

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }
    public function periode()
    {
        return $this->belongsTo(Periode::class, 'periode_id');
    }
    public function daftar_jadwal()
    {
        return $this->hasMany(Daftar_Jadwal::class, 'mapel_id');
    }
    public function gurus()
    {
        return $this->belongsToMany(Guru::class, 'pengampus');
    }
}
