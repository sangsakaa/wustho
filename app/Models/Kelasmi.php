<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kelasmi extends Model
{
    use HasFactory;
    protected $table = "kelasmi";
    // public function getHitungAttribute()
    // {
    //     return $this->hasMany(Pesertakelas::class)->whereSiswaId($this->id)->count();
    // }
}
