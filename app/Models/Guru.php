<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;

    protected $table = 'guru';

    protected $fillable = [
        'nama_guru',
        'jenis_kelamin',
        'agama',
        'tempat_lahir',
        'tanggal_lahir',
        'tanggal_masuk',
        'status',
        'jenjang',
    ];


    /**
     * Semua NIG milik guru
     */
    public function nig()
    {
        return $this->hasMany(Nig::class, 'guru_id');
    }


    /**
     * NIG terakhir milik guru
     */
    public function NigTerakhir()
    {
        return $this->hasOne(Nig::class, 'guru_id')
            ->latestOfMany();
    }


    /**
     * Jadwal guru
     */
    public function daftar_jadwal()
    {
        return $this->hasMany(
            Daftar_Jadwal::class,
            'guru_id'
        );
    }


    /**
     * User yang terkait dengan guru
     */
    public function user()
    {
        return $this->hasOne(User::class, 'guru_id');
    }


    /**
     * Mapel guru
     */
    public function mapel()
    {
        return $this->belongsToMany(
            Mapel::class,
            'pengampus'
        );
    }


    /**
     * Relasi guru dengan guru
     * melalui tabel pengampus.
     */
    public function gurus()
    {
        return $this->belongsToMany(
            Guru::class,
            'pengampus'
        )->withTimestamps();
    }
}
