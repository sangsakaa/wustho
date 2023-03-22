<?php

namespace App\Models;

use App\Models\Daftar_lulusan;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Daftar_Nominasi extends Model
{
    use HasFactory;

    public $guarded = [];
    protected $table = "daftar_nominasi";
    public function NomorUjian()
    {
        return $this->hasMany(Daftar_lulusan::class, 'id');
    }
}
