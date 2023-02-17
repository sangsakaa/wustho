<?php

namespace App\Models;

use App\Models\Guru;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Nig extends Model
{
    use HasFactory;

    public $guarded = [];
    protected $table = "nig";

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'guru_id', 'id');
    }
}
