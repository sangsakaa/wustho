<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Lulusan extends Model
{
    use HasFactory;
    protected $fillable = [
        'periode_id',
        'kelasmi_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'tanggal_kelulusan',
        'tanggal_lulus_hijriyah',
    ];
    public $guarded = [];
    protected $table = 'lulusan';
}
