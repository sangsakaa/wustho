<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Nominasi extends Model
{
    use HasFactory;

    public $guarded = [];
    protected $table = "nominasi";
    protected $fillable = [
        'kelasmi_id',
        'periode_id',
        'tanggal_mulai',
        'tanggal_selesai',
    ];
}
