<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Daftar_Nominasi extends Model
{
    use HasFactory;

    public $guarded = [];
    protected $table = "daftar_nominasi";
}