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
        return empty($search) ? static::query() : static::query()
            ->where(function ($query) use ($search) {
                $query->where('nama_asrama', 'like', '%' . $search . '%')
                    ->orWhere('type_asrama', 'like', '%' . $search . '%');
            })
        ->where('asramasiswa.periode_id', session('periode_id'));

    }
}
