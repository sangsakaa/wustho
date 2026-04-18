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
    public function pesertaasrama()
    {
        return $this->hasMany(Pesertaasrama::class, 'asramasiswa_id');
    }
    public function periode()
    {
        return $this->belongsTo(Periode::class, 'periode_id');
    }
    
    public static function search($search)
    {
        $query = static::query();

        if ($search) {
            $query->whereHas('asrama', function ($q) use ($search) {
                $q->where('nama_asrama', 'like', "%{$search}%")
                    ->orWhere('type_asrama', 'like', "%{$search}%");
            });
        }

        return $query; // ❗ penting: TANPA get()
    }
}
