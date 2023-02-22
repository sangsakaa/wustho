<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Transkip extends Model
{
    use HasFactory;

    public $guarded = [];
    protected $table = "transkip";
    public function NilatTranskip()
    {
        return $this->hasMany(Nilai_Transkip::class, 'transkip_id', 'id');
    }
}
