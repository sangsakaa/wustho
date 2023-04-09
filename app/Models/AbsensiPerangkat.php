<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class AbsensiPerangkat extends Model
{
    use HasFactory;

    public $guarded = [];
    protected $table = "absensi_perangkat";
    public function Sesi()
    {
        return $this->hasMany(SesiPerangkat::class, 'sesi_perangkat_id', 'id');
    }
}
