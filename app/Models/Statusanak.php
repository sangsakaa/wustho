<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statusanak extends Model
{
    use HasFactory;
    protected $table = "statusanak";
    protected $fillable = [
        // 
        'id',
        'siswa_id',
        'status_anak',
        'jumlah_saudara',
        'anak_ke',
        'created_at',
        'updated_at',
        'nama_ayah',
        'pekerjaan_ayah',
        'pekerjaan_ibu',
        'nomor_hp_ayah',
        'nama_ibu',
        'nomor_hp_ibu',
    ];
}
