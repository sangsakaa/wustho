<?php

namespace App\Models;

use App\Models\Pesertakelas;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Presensikelas extends Model
{
    use HasFactory;

    protected $table = 'presensikelas';

    public $guarded = [];
    public function pesertaKelas()
    {
        return $this->belongsTo(PesertaKelas::class, 'pesertakelas_id');
    }

}