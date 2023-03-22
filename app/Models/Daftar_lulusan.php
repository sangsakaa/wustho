<?php

namespace App\Models;

use App\Models\Nilai_Transkip;
use App\Models\Daftar_Nominasi;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Daftar_lulusan extends Model
{
    use HasFactory;

    public $guarded = [];
    protected $table = 'daftar_lulusan';
    public function DaftaLulusan()
    {
        return $this->hasMany(Nilai_Transkip::class, 'daftar_lulusan_id', 'id');
    }

    public function NomorUjian()
    {

        return $this->belongsTo(Daftar_Nominasi::class, 'id');
    }
}
