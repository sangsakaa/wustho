<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    use HasFactory;

    public $guarded = [];
    protected $table = 'jabatan';
    public function Jabatan()
    {
        return $this->belongsTo(JabatanPerangkat::class, 'id', 'perangkat_id');
    }
}
