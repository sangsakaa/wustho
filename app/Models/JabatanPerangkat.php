<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JabatanPerangkat extends Model
{
    protected $table = 'jabatan_perangkat';

    protected $fillable = [
        'perangkat_id',
        'jabatan_id'
    ];
}
