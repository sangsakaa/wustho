<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Absensikelas;
use App\Models\Pesertakelas;
use App\Models\Pesertaasrama;
use App\Models\Presensikelas;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function Personal()
    {
        $siswa_id = Auth::user()->siswa_id;
        $peserAsrama = Pesertaasrama::query()
            ->join('asramasiswa', 'asramasiswa.id', '=', 'pesertaasrama.asramasiswa_id')
            ->join('periode', 'periode.id', 'asramasiswa.periode_id')
            ->join('semester', 'semester.id', 'periode.semester_id')
            ->join('asrama', 'asrama.id', '=', 'asramasiswa.asrama_id')
            ->where('asramasiswa.periode_id', session('periode_id'))
            ->where('pesertaasrama.siswa_id', $siswa_id)
            ->select('pesertaasrama.id')
            ->first();
        $user = Siswa::query()
            ->join('nis', 'nis.siswa_id', '=', 'siswa.id')
            ->select('siswa.id', 'nama_siswa', 'nis', 'tempat_lahir', 'tanggal_lahir', 'kota_asal', 'agama')
            ->where('siswa.id', $siswa_id)->first();
        return view(
            'user/user',
            [
                'siswa' => $user,
                'peserAsrama' => $peserAsrama
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
            ->where('kelasmi.periode_id', session('periode_id'))
        ->get();
        $hadir = $user->where('keterangan', 'hadir')->count();
        $izin = $user->where('keterangan', 'izin')->count();
        $sakit = $user->where('keterangan', 'sakit')->count();
        $alfa = $user->where('keterangan', 'alfa')->count();
        return view(
            'user/riwayatkehadiran',
            [
                'siswa' => $user,
                'siswa_id' => $siswa_id,
                'title' => $title,
                'hadir' => $hadir,
                'izin' => $izin,
                'sakit' => $sakit,
                'alfa' => $alfa,
            ]
        );
    }
    public function DashboardUser()
    {

        $siswa_id = Auth::user()->siswa_id;
        // dd($siswa_id);
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
        $presensi = Pesertakelas::query()
        ->select(
            DB::raw('SUM(CASE WHEN absensikelas.keterangan = "hadir" THEN 1 ELSE 0 END) as hadir'),
            DB::raw('SUM(CASE WHEN absensikelas.keterangan = "alfa" THEN 1 ELSE 0 END) as alfa'),
            DB::raw('SUM(CASE WHEN absensikelas.keterangan = "sakit" THEN 1 ELSE 0 END) as sakit'),
            DB::raw('SUM(CASE WHEN absensikelas.keterangan = "izin" THEN 1 ELSE 0 END) as izin'),
            'periode',
            'ket_semester'

        )
            ->join('kelasmi', 'kelasmi.id', 'pesertakelas.kelasmi_id')
            ->join('absensikelas', 'absensikelas.pesertakelas_id', 'pesertakelas.id')
            ->join('sesikelas', 'sesikelas.id', '=', 'absensikelas.sesikelas_id')
            ->join('periode', 'periode.id', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', 'periode.semester_id')
        ->where('pesertakelas.siswa_id', $siswa_id)
            // ->where('kelasmi.periode_id', session('periode_id'))
            ->groupBy('pesertakelas.id', 'periode', 'ket_semester') // Jika Anda ingin mengelompokkan hasil per siswa
        ->get();

        // dd($presensi);
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