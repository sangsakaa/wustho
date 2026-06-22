<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CalonSiswa extends Model
{
    protected $fillable = [
        'api_id',
        'jenjang_id',
        'jenjang',
        'jenjang_title',

        'nomor_pendaftaran',
        'nama',
        'jenis_kelamin',

        'nisn',
        'nis',
        'nik',
        'nomor_kk',
        'no_kip',
        'npsn',
        'alumni',

        'tempat_lahir',
        'tanggal_lahir',

        'anak_ke',
        'jumlah_saudara_kandung',

        'agama',
        'kewarganegaraan',
        'rencana_pendidikan',

        'alamat_jalan',
        'nama_dusun',
        'rt',
        'rw',
        'kode_pos',

        'tinggi_badan',
        'berat_badan',
        'lingkar_kepala',

        'status',
        'no_registrasi_akta',

        'user_id',
        'tapel_id',
        'kelurahan_desa',
        'riwayat_kesehatan',
        'kebutuhan_khusus',

        'asal_sekolah',
        'user_agent',
        'ip',
        'data_api',
    ];

    protected $casts = [
        'data_api' => 'array',
    ];
}
