<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Transkip extends Model
{
    use HasFactory;

    public $guarded = [];
    protected $table = "transkip";
    public function NilatTranskip()
    {
        return $this->hasMany(Nilai_Transkip::class, 'transkip_id', 'id');
    }
    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'mapel_id');
    }

    public function jenisUjian()
    {
        return $this->belongsTo(Jenis_Ujian::class, 'jenis_ujian_id');
    }

    public function kelasmi()
    {
        return $this->belongsTo(Kelasmi::class, 'kelasmi_id');
    }

    public function nilaiTranskip()
    {
        return $this->hasMany(
            Nilai_Transkip::class,
            'transkip_id'
        );
    }
}
