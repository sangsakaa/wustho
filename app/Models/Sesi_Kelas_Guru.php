<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Sesi_Kelas_Guru extends Model
{
    use HasFactory;

    public $guarded = [];
    protected $table = "sesi_kelas_guru";
}
