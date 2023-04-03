<?php

namespace App\Models;

use App\Models\Guru;
use App\Models\Jadwal;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Daftar_Jadwal extends Model
{
    use HasFactory;

    public $guarded = [];
    protected $table = "daftar_jadwal";
    public function daftar_jadwal()
    {
        return $this->hasMany(Jadwal::class, 'jadwal_id');
    }

    public function guru()
    {
        return $this->hasMany(Guru::class);
    }
}
