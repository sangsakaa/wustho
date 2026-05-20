<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Lembaga extends Model
{
    protected $fillable = [
        'kode',
        'nama',
        'deskripsi',
        'logo',
        'is_active'
    ];

    public function siswa()
    {
        return $this->hasMany(Siswa::class);
    }

    public function kelas()
    {
        return $this->hasMany(Kelas::class);
    }

    public function guru()
    {
        return $this->hasMany(Guru::class);
    }
}
