<?php

namespace App\Http\Controllers\Api;

use App\Models\Siswa;
use Illuminate\Http\Request;

class ApiSiswaController
{
    public function index()

    {
        $siswa = Siswa::all();
        return response()->json(['siswa' => $siswa]);
    }
    public function show(Siswa $siswa)
    {
        $siswa = Siswa::find($siswa);
        return response()->json(['siswa' => $siswa]);
    }
}
