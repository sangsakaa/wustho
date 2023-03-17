<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Nominasi extends Model
{
    use HasFactory;

    public $guarded = [];
    protected $table = "nominasi";
}
