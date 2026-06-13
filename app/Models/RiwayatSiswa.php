<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatSiswa extends Model
{
    protected $table = 'riwayat_siswa';

    protected $fillable = [
        'siswa_id',
        'periode_id',
        'kelas_id',
        'status',
        'keterangan',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function periode()
    {
        return $this->belongsTo(Periode::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
}
