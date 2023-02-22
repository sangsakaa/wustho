<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Nilai_Transkip extends Model
{
    use HasFactory;

    public $guarded = [];
    protected $table = "nilai_transkip";
    public function Transkip()
    {
        return $this->belongsTo(Transkip::class, 'transkip_id', 'id');
    }
}
