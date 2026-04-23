<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Perangkat extends Model
{
    protected $table = 'perangkat';

    protected $fillable = [
        'nama_perangkat',
        'jenis_kelamin',
        'agama',
        'tempat_lahir',
        'tanggal_lahir',
        'tanggal_masuk',
        'status'
    ];

    // RELASI ke jabatan (many to many)
    public function jabatan()
    {
        return $this->belongsToMany(Jabatan::class, 'jabatan_perangkat')
            ->withTimestamps();
    }
}
