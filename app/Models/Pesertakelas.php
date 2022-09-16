<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pesertakelas extends Model
{
    use HasFactory;
    protected $table = "pesertakelas";
    protected $fillable = ['siswa_id', 'kelas_id'];
    // public function getHitungAttribute()
    // {
    //     return $this->hasMany(Pesertakelas::class)->whereSiswaId($this->id)->count();
    // }
}
