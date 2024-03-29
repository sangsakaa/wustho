<?php

namespace App\Models;

use App\Models\JabatanPerangkat;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Perangkat extends Model
{
    use HasFactory;

    public $guarded = [];
    protected $table = "perangkat";
    public function Jabatan()
    {
        return $this->belongsTo(JabatanPerangkat::class, 'id', 'perangkat_id');
    }
}
