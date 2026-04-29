<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilaimapel extends Model
{
    use HasFactory;
    protected $table = "nilaimapel";
    protected $fillable = [
        'kelasmi_id',
        'guru_id',
        'mapel_id',
    ];
}
