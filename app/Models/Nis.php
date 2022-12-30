<?php

namespace App\Models;

use App\Models\Siswa;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Nis extends Model
{
    use HasFactory;
    protected $table = "nis";

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id', 'id');
       
    }
}
