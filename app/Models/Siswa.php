<?php

namespace App\Models;

use App\Models\Nis;
use App\Models\Pesertaasrama;
use App\Models\Pesertakelas;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Siswa extends Model
{
    use HasFactory, LogsActivity;

    protected $table = "siswa";

    protected $fillable = [
        'nama_siswa',
        'jenis_kelamin',
        'status_siswa',
        'agama',
        'tempat_lahir',
        'tanggal_lahir',
        'kota_asal',
    ];


    protected $guarded = [];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty();
    }
    public function user()
    {
        return $this->hasOne(User::class);
    }
    public function nis()
    {
        return $this->hasOne(Nis::class, 'siswa_id');
    }
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
    public function riwayat()
    {
        return $this->hasMany(RiwayatSiswa::class);
    }
    public function kelas()
    {
        return $this->hasOneThrough(
            Kelasmi::class,
            Pesertakelas::class,
            'siswa_id',
            'id',
            'id',
            'kelasmi_id'
        )->latestOfMany();
    }
}
