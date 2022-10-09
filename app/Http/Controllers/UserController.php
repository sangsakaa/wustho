<?php

namespace App\Http\Controllers;

use App\Models\Pesertakelas;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function Personal()
    {
        $siswa_id = Auth::user()->siswa_id;
        $user = Siswa::query()
            ->join('nis', 'nis.siswa_id', '=', 'siswa.id')
            ->where('siswa.id', $siswa_id)->first();
        return view('user/user', ['siswa' => $user]);
    }
    public function Riwayatkelas()
    {
        $siswa_id = Auth::user()->siswa_id;
        $user = Pesertakelas::query()
            ->join('kelasmi', 'kelasmi.id', 'pesertakelas.kelasmi_id')
            ->join('periode', 'periode.id', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', 'periode.semester_id')
            ->where('pesertakelas.siswa_id', $siswa_id)->get();
        return view('user/riwayatkelas', ['siswa' => $user]);
    }
}
