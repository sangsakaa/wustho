<?php

namespace App\Http\Controllers\Api;

use App\Models\Nis;
use App\Models\Siswa;
use App\Models\Kelasmi;
use App\Models\Periode;
use App\Models\Asramasiswa;
use App\Models\Absensikelas;
use Illuminate\Http\Request;
use App\Models\Pesertaasrama;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ApiSiswaController
{
    public function dataAsrama(Request $request)
    {
        $periode = Periode::query()
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->select('periode.id', 'ket_semester', 'periode.periode')
            ->latest('periode.created_at')
            ->first();
        $tgl = $request->tgl ? Carbon::parse($request->tgl) : now();
        $pesertaasrama = Pesertaasrama::query()
            ->join('siswa', 'siswa.id', '=', 'pesertaasrama.siswa_id')
            ->join('asramasiswa', 'asramasiswa.id', '=', 'pesertaasrama.asramasiswa_id')
            ->join('asrama', 'asrama.id', '=', 'asramasiswa.asrama_id')
            ->select('siswa.id as siswa_id', 'asrama.nama_asrama')
        ->where('asramasiswa.periode_id', $periode->id)
            
            // ->where('asramasiswa.periode_id', session('periode_id'))
        ;
        $dataAbsensiKelas = Absensikelas::query()
            ->join('sesikelas', 'sesikelas.id', '=', 'absensikelas.sesikelas_id')
            ->join('pesertakelas', 'pesertakelas.id', '=', 'absensikelas.pesertakelas_id')
            ->join('siswa', 'siswa.id', '=', 'pesertakelas.siswa_id')
            ->join('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
            ->joinSub($pesertaasrama, 'peserta_asrama', function ($join) {
                $join->on('peserta_asrama.siswa_id', '=', 'siswa.id');
            })
            ->select('kelasmi.jenjang',  'peserta_asrama.nama_asrama', 'absensikelas.id As id_sesi_kelas', 'siswa.nama_siswa', 'absensikelas.keterangan', 'nama_kelas', 'tgl')
            ->whereIn('keterangan', ['sakit', 'izin', 'alfa', 'hadir'])
            ->orderBy('peserta_asrama.nama_asrama')
            ->orderBy('kelasmi.nama_kelas')
            ->orderBy('absensikelas.keterangan')
            ->orderBy('siswa.nama_siswa')
            ->where('kelasmi.periode_id', $periode->id)
            ->groupby('nama_siswa', 'jenjang', 'keterangan', 'nama_kelas', 'tgl', 'absensikelas.id',)
        ->get();
        return response()->json(
            [

                'dataAbsensiKelas' => $dataAbsensiKelas,
                'tgl' => $tgl,
            ]
        );
    }
    public function getDataSiswa()
    {
        // Mengambil semua peserta asrama untuk seorang siswa
        $periode = Periode::query()
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->select('periode.id', 'ket_semester', 'periode.periode')
            ->latest('periode.created_at')
            ->first();
        $siswa = Siswa::query()
            ->join('nis', 'nis.siswa_id', '=', 'siswa.id')
            ->join('pesertaasrama', 'pesertaasrama.siswa_id', '=', 'siswa.id')
            ->join('asramasiswa', 'asramasiswa.id', '=', 'pesertaasrama.asramasiswa_id')
            ->join('asrama', 'asrama.id', '=', 'asramasiswa.asrama_id')
            ->join('pesertakelas', 'pesertakelas.siswa_id', '=', 'siswa.id')
            ->join('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
            ->select([
                'nis.nis',
                'siswa.nama_siswa',
                'nis.tanggal_masuk',
                'nis.madrasah_diniyah',
                'nis.nama_lembaga',
                'siswa.jenis_kelamin',
                'siswa.agama',
                'siswa.tempat_lahir',
                'siswa.tanggal_lahir',
                'siswa.kota_asal',
                'asrama.nama_asrama',
                'kelasmi.nama_kelas',
            'asramasiswa.periode_id',
            ])
            ->where('asramasiswa.periode_id', $periode->id)
            ->where('kelasmi.periode_id', $periode->id)
            // Mengubah ini menjadi 'nis.nis'
            ->get();
        return response()->json(['siswa' => $siswa]);
        // Mengambil siswa yang terkait dengan suatu entri peserta asrama
        
    }
}
