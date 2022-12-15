<?php

namespace App\Models;

use App\Models\Presensiasrama;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sesiasrama extends Model
{
    use HasFactory;
    protected $table = "sesiasrama";
    public function SesiAsrama()
    {
        return $this->hasMany(Presensiasrama::class, 'sesiasrama_id', 'id');
    }
}
