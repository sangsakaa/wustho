<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KalenderPendidikan extends Model
{
    protected $fillable = [
        'nama_kegiatan',
        'tanggal_mulai',
        'tanggal_selesai',
        'kategori',
        'keterangan',
        'aktif',
        'periode_id',
    ];



    public function periode()
    {
        return $this->belongsTo(Periode::class);
    }
}

