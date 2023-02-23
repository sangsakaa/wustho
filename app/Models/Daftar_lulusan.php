<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Nilai_Transkip;

use Illuminate\Database\Eloquent\Model;

class Daftar_lulusan extends Model
{
    use HasFactory;

    public $guarded = [];
    protected $table = 'daftar_lulusan';
    public function DaftaLulusan()
    {
        return $this->hasMany(Nilai_Transkip::class, 'daftar_lulusan_id', 'id');
    }
}
