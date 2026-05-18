<?php

namespace App\Models;


use App\Models\Pesertakelas;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kelasmi extends Model
{
    use HasFactory;
    protected $table = "kelasmi";


    public function KelasMi()
    {
        return $this->hasMany(Pesertakelas::class, 'id', 'kelasmi');
    }
    public static function search($search)
    {
        // dd($search);
        return empty($search) ? static::query() : static::query()
            ->where('nama_kelas', 'like', '%' . $search . '%');
    }
    public function periode()
    {
        return $this->belongsTo(Periode::class, 'periode_id');
    }

    public function pesertakelas()
    {
        return $this->hasMany(Pesertakelas::class, 'kelasmi_id');
    }

    public function sesikelas()
    {
        return $this->hasMany(Sesikelas::class, 'kelasmi_id');
    }

    public function absensikelas()
    {
        return $this->hasManyThrough(
            Absensikelas::class,
            Sesikelas::class,
            'kelasmi_id',
            'sesikelas_id'
        );
    }
    public function presensi()
    {
        return $this->hasManyThrough(Presensikelas::class, Pesertakelas::class);
    }
}
