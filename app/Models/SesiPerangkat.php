<?php

namespace App\Models;

use App\Models\AbsensiPerangkat;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SesiPerangkat extends Model
{
    use HasFactory;

    public $guarded = [];
    protected $table = "sesi_perangkat";
    public function SesiP()
    {
        return $this->belongsTo(AbsensiPerangkat::class, 'id', 'sesi_perangkat_id');
    }
}
