<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Sesikelas extends Model
{
    use HasFactory;

    protected $table = 'sesikelas';

    public $guarded = [];

    public function absensi()
    {
        return $this->hasMany(Absensikelas::class, 'sesikelas_id', 'id');
    }
    public function kelasmi()
    {
        return $this->belongsTo(\App\Models\Kelasmi::class, 'kelasmi_id');
    }
}
