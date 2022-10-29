<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asrama extends Model
{
    use HasFactory;
    protected $table = "asrama";
    public function asramaSiswa()
    {
        return $this->hasMany(Asramasiswa::class, 'asrama_id', 'id');
    }
}
