<?php

namespace App\Models;

use App\Models\Daftar_Jadwal;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Jadwal extends Model
{
    use HasFactory;

    public $guarded = [];
    protected $table = "jadwal";
    public function daftar_jadwal()
    {
        return $this->hasMany(Daftar_Jadwal::class, 'jadwal_id');
    }
    public static function search($search)
    {
        // dd($search);
        return empty($search) ? static::query() : static::query()
            ->where('nama_kelas', 'like', '%' . $search . '%')
            ->Orwhere('nama_guru', 'like', '%' . $search . '%');
    }
}
