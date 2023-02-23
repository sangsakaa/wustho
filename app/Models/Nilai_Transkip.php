<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use App\Models\Daftar_lulusan;

class Nilai_Transkip extends Model
{
    use HasFactory;

    public $guarded = [];
    protected $table = "nilai_transkip";

    public function Transkip()
    {
        return $this->belongsTo(Transkip::class, 'transkip_id', 'id');
    }
    public function NilaiTranskip()
    {
        return $this->belongsTo(Daftar_lulusan::class, 'daftar_lulusan_id', 'id');
    }
}
