<?php

namespace App\Http\Controllers\Api;

use App\Models\Siswa;
use App\Models\Nis;
use Illuminate\Http\Request;

class ApiSiswaController
{
    public function index()

    {
        $siswa = Siswa::query()
            ->leftjoin('nis', 'nis.siswa_id', '=', 'siswa.id')
            ->get();
        return response()->json(['siswa' => $siswa]);
    }
    public function show(Siswa $siswa)
    {
        $siswa = Siswa::find($siswa);
        return response()->json(['siswa' => $siswa]);
    }
    public function nis(Siswa $siswa, Nis $nis)
    {
        $nis = Nis::find($siswa);
        return response()->json(['nis' => $nis]);
        
    }
}
