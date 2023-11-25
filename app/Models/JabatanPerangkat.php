<?php

namespace App\Models;

use App\Models\Perangkat;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JabatanPerangkat extends Model
{
    use HasFactory;

    public $guarded = [];
    protected $table = 'jabatan_perangkat';
    public function JabatanX()
    {
        return $this->hasMany(Perangkat::class, 'id', 'perangkat_id');
    }
    public function titleJab()
    {
        return $this->hasMany(Jabatan::class, 'id', 'jabatan_id');
    }
}
