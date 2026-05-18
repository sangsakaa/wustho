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
    protected $fillable = [
        'nama_guru',
        'jenis_kelamin',
        'agama',
        'tempat_lahir',
        'tanggal_lahir',
        'tanggal_masuk',
        'status',
        'jenjang'
    ];
    public function NigTerakhir()
    {

        return $this->hasOne(Nig::class)->latestOfMany();
    }

    public function daftar_jadwal()
    {
        return $this->hasMany(Daftar_Jadwal::class, 'guru_id'); // ✅ WAJIB
    }
    public function nig()
    {
        return $this->hasOne(Nig::class, 'guru_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'guru_id');
    }
    public function mapel()
    {
        return $this->belongsToMany(Mapel::class, 'pengampus');
    }
    public function gurus()
    {
        return $this->belongsToMany(Guru::class, 'pengampus')
            ->withTimestamps();
    }
}
