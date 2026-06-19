<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    protected $table = 'jabatan';

    protected $fillable = [
        'nama_jabatan'
    ];
    // RELASI ke perangkat
    public function perangkat()
    {
        return $this->belongsToMany(Perangkat::class, 'jabatan_perangkat')
            ->withTimestamps();
    }
}
