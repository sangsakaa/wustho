<?php

namespace App\Models;

use App\Models\Siswa;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pesertakelas extends Model
{
    use HasFactory;
    protected $table = "pesertakelas";
    protected $fillable = ['siswa_id', 'kelas_id'];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id', 'id');
    }
}
