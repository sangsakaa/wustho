<?php

namespace App\Models;


use App\Models\Nis;
use App\Models\Pesertakelas;
use App\Models\Pesertaasrama;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Siswa extends Model
{
    use HasFactory;
    protected $table = "siswa";
    protected $fillable = [
        // 
        'id',
        'nama_siswa',
        'jenis_kelamin',
        'agama',
        'tempat_lahir',
        'tanggal_lahir',
        'kota_asal',
        'created_at',
        'updated_at',
        'status_anak_id',
        'siswa_id',
        'status_anak',
        'jumlah_saudara',
        'anak_ke',
        'status_anak_created_at',
        'status_anak_updated_at',
        'nama_ayah',
        'pekerjaan_ayah',
        'pekerjaan_ibu',
        'nomor_hp_ayah',
        'nama_ibu',
        'nomor_hp_ibu',
        'nis_id',
        'siswa_id',
        'nis',
        'madrasah_diniyah',
        'nama_lembaga',
        'tanggal_masuk',
        'nis_created_at',
        'nis_updated_at'



    ];
    



    public function kelasTerakhir()
    {
        return $this->hasOne(Pesertakelas::class)->latestOfMany();
    }
    public function NisTerakhir()
    {
        
        return $this->hasOne(Nis::class)->latestOfMany();
    }
    public function asramaTerkhir()
    {
        return $this->hasOne(Pesertaasrama::class)->latestOfMany();
    }
    public static function search($search)
    {
        // dd($search);
        return empty($search) ? static::query() : static::query()
            ->Orwhere('nis', 'like', '%' . $search . '%')
            ->OrWhere('nama_siswa', 'like', '%' . $search . '%'); 
    }
    
    public function kelasmi()
    {
        return $this->belongsToMany(Kelasmi::class, 'pesertakelas', 'siswa_id', 'kelasmi_id');
    }
    

}
