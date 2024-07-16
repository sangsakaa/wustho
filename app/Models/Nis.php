<?php

namespace App\Models;

use App\Models\Siswa;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Nis extends Model
{
    use HasFactory;
    protected $table = "nis";
    protected $fillable = [
        'id',
        'siswa_id',
        'nis',
        'madrasah_diniyah',
        'nama_lembaga',
        'tanggal_masuk',
        'created_at',
        'updated_at'
    ];
    

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id', 'id');
       
    }
}
