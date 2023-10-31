<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asramasiswa extends Model
{
    use HasFactory;
    protected $table = "asramasiswa";
    public function asramaSiswa()
    {
        return $this->hasMany(Asramasiswa::class, 'id', 'asramasiswa_id');
    }
    public function asrama()
    {
        return $this->belongsTo(Asrama::class, 'asrama_id', 'id');
    }
    public static function search($search)
    {
        // dd($search);
        return empty($search) ? static::query() : static::query()
            ->where('nama_asrama', 'like', '%' . $search . '%')
            ->Orwhere('type_asrama', 'like', '%' . $search . '%');
    }
}
