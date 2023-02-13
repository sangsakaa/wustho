<?php

namespace App\Http\Controllers;

use App\Models\Pesertaasrama;
use App\Models\Pesertakelas;
use App\Models\Presensikelas;
use App\Models\Siswa;

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
        return view(
            'user/user',
            [
                'siswa' => $user,
            ]
        );
    }
    public function Riwayatkelas()
    {
        $siswa_id = Auth::user()->siswa_id;
        $user = Pesertakelas::query()
            ->join('kelasmi', 'kelasmi.id', 'pesertakelas.kelasmi_id')
            ->join('periode', 'periode.id', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', 'periode.semester_id')
        ->where('pesertakelas.siswa_id', $siswa_id)
            ->get();
        return view('user/riwayatkelas', ['siswa' => $user]);
    }
    public function Riwayatkehadiran()
    {

        $siswa_id = Auth::user()->siswa_id;
        $title = Siswa::query()
            ->join('nis', 'nis.siswa_id', '=', 'siswa.id')
            ->where('siswa.id', $siswa_id)->first();
        $user = Pesertakelas::query()
            ->join('kelasmi', 'kelasmi.id', 'pesertakelas.kelasmi_id')
            ->join('absensikelas', 'absensikelas.pesertakelas_id', 'pesertakelas.id')
            ->join('sesikelas', 'sesikelas.id', '=', 'absensikelas.sesikelas_id')
            ->join('periode', 'periode.id', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', 'periode.semester_id')

            ->where('pesertakelas.siswa_id', $siswa_id)
            ->paginate(10);
        return view(
            'user/riwayatkehadiran',
            [
                'siswa' => $user,
                'siswa_id' => $siswa_id,
                'title' => $title
            ]
        );
    }
    public function DashboardUser()
    {

        $siswa_id = Auth::user()->siswa_id;
        $title = Siswa::query()
            ->join('nis', 'nis.siswa_id', '=', 'siswa.id')
            ->where('siswa.id', $siswa_id)->first();
        $siswa_id = Auth::user()->siswa_id;
        $jmlmapel = Pesertakelas::query()
            ->join('nilai', 'nilai.pesertakelas_id', '=', 'pesertakelas.id')
            ->join('nilaimapel', 'nilaimapel.id', '=', 'nilai.nilaimapel_id')
            ->join('mapel', 'mapel.id', '=', 'nilaimapel.mapel_id')
            ->Where('siswa_id', $siswa_id)
            ->get();
        $NH = $jmlmapel->sum('nilai_harian');
        $NU = $jmlmapel->sum('nilai_ujian');
        $jmlNH = $jmlmapel->count('nilai_harian');
        $jmlNU = $jmlmapel->count('nilai_ujian');
        $x = $jmlNH * 2 + $jmlNU * 2;
        $a = $jmlNH !== 0 ? $NH / $jmlNH : 0;
        $b = $jmlNU !== 0 ? $NU / $jmlNU : 0;
        $c = $x !== 0 ? $a + $b / $x : 0;
        $jml = $jmlmapel->count();
        $user = Pesertaasrama::query()
            ->join('asramasiswa', 'asramasiswa.id', '=', 'pesertaasrama.asramasiswa_id')
            ->join('periode', 'periode.id', 'asramasiswa.periode_id')
            ->join('semester', 'semester.id', 'periode.semester_id')
            ->join('asrama', 'asrama.id', '=', 'asramasiswa.asrama_id')
            ->where('pesertaasrama.siswa_id', $siswa_id)
            ->get();
        $presensi = Presensikelas::query()
        ->join('pesertakelas', 'pesertakelas.id', '=', 'presensikelas.pesertakelas_id')
            ->join('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
            ->join('periode', 'periode.id', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', 'periode.semester_id')
        ->where('pesertakelas.siswa_id', $siswa_id)
        ->get();
        return view(
            'user/userdashboard',
            [
                'title' => $title,
                'presensi' => $presensi,
                'Asrama' => $user,
                'jmlmapel' => $jmlmapel,
                'NU' => $NU,
                'jml' => $jml,
                'a' => $a,
                'b' => $c,

            ]
        );
    }
}