<?php

namespace App\Models;

use App\Models\Sesiasrama;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Presensiasrama extends Model
{
    use HasFactory;

    protected $table = 'presensiasrama';

    public function SesiAsrama()
    {
        return $this->belongsTo(Sesiasrama::class, 'sesiasrama_id', 'id');
    }
}
