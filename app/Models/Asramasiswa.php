<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asramasiswa extends Model
{
    use HasFactory;
    protected $table = "asramasiswa";
    public function asramaSiswa()
    {
        return $this->hasMany(Asramasiswa::class, 'id', 'asramasiswa_id');
    }
    public function asrama()
    {
        return $this->belongsTo(Asrama::class, 'asrama_id', 'id');
    }
}
