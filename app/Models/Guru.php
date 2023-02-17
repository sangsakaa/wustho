<?php

namespace App\Models;

use App\Models\Nig;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Guru extends Model
{
    use HasFactory;
    protected $table = "guru";
    public function NigTerakhir()
    {

        return $this->hasOne(Nig::class)->latestOfMany();
    }
}
