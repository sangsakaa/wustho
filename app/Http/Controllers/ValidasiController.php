<?php

namespace App\Http\Controllers;


use App\Models\Daftar_lulusan;
use App\Models\Kelasmi;
use App\Models\Lulusan;
use App\Models\Nilai_Transkip;
use App\Models\Nis;
use App\Models\Perangkat;
use App\Models\Periode;
use App\Models\Pesertakelas;
use App\Models\Siswa;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Riskihajar\Terbilang\Facades\Terbilang;


class ValidasiController
{
    public function index(Kelasmi $kelasmi)
    {
        $dataKelas = Kelasmi::query()
            ->where('kelasmi.periode_id', session('periode_id'))
            ->orderby('nama_kelas')
            ->get();
        $data = Pesertakelas::query()
            ->join('siswa', 'siswa.id', '=', 'pesertakelas.siswa_id')
            ->join('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
            ->join('nis', 'siswa.id', '=', 'nis.siswa_id')
            ->leftjoin('statusanak', 'siswa.id', '=', 'statusanak.siswa_id')
            ->leftjoin('statuspengamal', 'siswa.id', '=', 'statuspengamal.siswa_id')
            // ->select('siswa.nama_siswa')
            ->where('kelasmi.periode_id', session('periode_id'))
            ->orderby('nama_kelas')
            ->orderby('nama_siswa');
        if (request('cari')) {
            $data->where('nama_kelas', 'like', '%' . request('cari') . '%');
        }
        return view(
            'validasi.index',
            [
                'data' => $data->get(),
                'dataKelas' => $dataKelas,
                'kelasmi' => $kelasmi,

            ]
        );
    }
    public function blangkoijazah(Siswa $siswa, Lulusan $lulusan)
    {
        $dataPeriode = Periode::query()
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->select('periode.id', 'periode.periode', 'semester.ket_semester')
            ->where('periode.id', session('periode_id'))
            ->orderby('ket_semester', 'desc')
            ->get();
        $jenjang = Kelasmi::first();
        $jenjang = $jenjang->jenjang;

        // Determine the code segment based on jenjang
        $codeSegment = '';
        if ($jenjang == 'Wustho') {
            $codeSegment = 'II';
        } elseif (
            $jenjang == 'Ula'
        ) {
            $codeSegment = 'I';
        }
        $kepalaSekolah = Perangkat::query()
            ->join('jabatan_perangkat', 'jabatan_perangkat.perangkat_id', 'perangkat.id')
            ->join('jabatan', 'jabatan.id', 'jabatan_perangkat.jabatan_id')
            ->where('nama_jabatan', 'Kepala Sekolah')->first();
        // dd($kepalaSekolah);
        $DataIjaza = $lulusan::query()
            ->join('kelasmi', 'kelasmi.id', '=', 'lulusan.kelasmi_id')
        ->select('kelasmi.nama_kelas')
        ->where('kelasmi.id', $lulusan->kelasmi_id)->first();
        $dataKelas = Kelasmi::query()
            ->join('kelas', 'kelas.id', '=', 'kelasmi.kelas_id')
            ->where('kelasmi.periode_id', session('periode_id'))
            ->where('kelas.kelas', 3)
            ->select('kelasmi.id', 'nama_kelas', 'jenjang')
            ->orderby('nama_kelas')
            ->get();
        $daftarLulusan = Daftar_lulusan::query()
            ->join('lulusan', 'lulusan.id', '=', 'daftar_lulusan.lulusan_id')
            ->join('pesertakelas', 'pesertakelas.id', '=', 'daftar_lulusan.pesertakelas_id')
            ->join('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
            ->join('kelas', 'kelas.id', '=', 'kelasmi.kelas_id')
            ->join('daftar_nominasi', 'daftar_nominasi.pesertakelas_id', '=', 'daftar_lulusan.pesertakelas_id')
            ->join('siswa', 'siswa.id', '=', 'pesertakelas.siswa_id')
            ->join('nis', 'siswa.id', '=', 'nis.siswa_id')
            ->join('statusanak', 'siswa.id', '=', 'statusanak.siswa_id')
            ->where('lulusan.kelasmi_id', $lulusan->kelasmi_id)
            
            ->select(
                [
                    'nis.nis',
                'kelas.kelas',
                'kelasmi.id',
                'kelasmi.nama_kelas',
                    'siswa.nama_siswa',
                    'siswa.tempat_lahir',
                    'statusanak.nama_ayah',
                    'siswa.tanggal_lahir',
                    'lulusan.tanggal_mulai',
                    'lulusan.tanggal_selesai',
                    'lulusan.tanggal_kelulusan',
                'lulusan.tanggal_lulus_hijriyah',
                    'daftar_lulusan.nomor_ijazah',
                'daftar_nominasi.nomor_ujian',


                ]
        );
        if (request('cari')) {
            $daftarLulusan->where('kelasmi.id', 'like', '%' . request('cari') . '%');
        }
        

        return view(
            'validasi.blangkoijazah',
            [
                'siswa' => $siswa,
                'data' => $daftarLulusan->get(),
                'dataKelas' => $dataKelas,
                'kelasmi' => $lulusan,
                'DataIjaza' => $DataIjaza,
                'dataPeriode' => $dataPeriode
                

            ]
        );
    }
    public function blangkoTranskip(Lulusan $lulusan)
    {
        $periodeId = session('periode_id');

        $dataPeriode = Periode::query()
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->select('periode.id', 'periode.periode', 'semester.ket_semester')
            ->where('periode.id', $periodeId)
            ->orderBy('ket_semester', 'desc')
            ->get();

        $dataKelas = Kelasmi::query()
            ->join('kelas', 'kelas.id', '=', 'kelasmi.kelas_id')
            ->where('kelasmi.periode_id', $periodeId)
            ->where('kelas.kelas', 3)
            ->select('kelasmi.id', 'nama_kelas', 'jenjang')
            ->orderBy('nama_kelas')
            ->get();

        $kepalaSekolah = Perangkat::query()
            ->join('jabatan_perangkat', 'jabatan_perangkat.perangkat_id', '=', 'perangkat.id')
            ->join('jabatan', 'jabatan.id', '=', 'jabatan_perangkat.jabatan_id')
            ->where('nama_jabatan', 'Kepala Sekolah')
            ->first();

        $dataLulusan = Lulusan::query()
            ->join('kelasmi', 'kelasmi.id', '=', 'lulusan.kelasmi_id')
            ->select(
            'lulusan.id',
            'nama_kelas',
            'tanggal_kelulusan',
            'tanggal_lulus_hijriyah'
            )
            ->where('lulusan.id', $lulusan->id)
            ->first();

        $data_lulusan = Daftar_lulusan::query()
            ->join('lulusan', 'lulusan.id', '=', 'daftar_lulusan.lulusan_id')
            ->join('pesertakelas', 'pesertakelas.id', '=', 'daftar_lulusan.pesertakelas_id')
            ->join('nilai_transkip', 'nilai_transkip.daftar_lulusan_id', '=', 'daftar_lulusan.id')
            ->join('transkip', 'transkip.id', '=', 'nilai_transkip.transkip_id')
            ->join('siswa', 'siswa.id', '=', 'pesertakelas.siswa_id')
            ->join('nis', 'siswa.id', '=', 'nis.siswa_id')
            ->select(
            'daftar_lulusan.id',
                'daftar_lulusan.lulusan_id',
            'nama_siswa',
            'nis',
            'tanggal_kelulusan',
            'tanggal_selesai',
            'tanggal_mulai'
            )
            ->where('daftar_lulusan.lulusan_id', $lulusan->id)
            ->distinct()
            ->get();

        $daftarIds = $data_lulusan->pluck('id');

        $data_nilai_tulis = Nilai_Transkip::query()
            ->join('transkip', 'transkip.id', '=', 'nilai_transkip.transkip_id')
            ->join('mapel', 'mapel.id', '=', 'transkip.mapel_id')
            ->join('jenis_ujian', 'jenis_ujian.id', '=', 'transkip.jenis_ujian_id')
            ->select(
                'nilai_transkip.daftar_lulusan_id',
                'nama_ujian',
                'nilai_transkip.nilai_akhir',
                'mapel'
            )
            ->where('jenis_ujian.nama_ujian', 'tulis')
            ->whereIn('nilai_transkip.daftar_lulusan_id', $daftarIds)
            ->get();

        $data_nilai_praktek = Nilai_Transkip::query()
            ->join('transkip', 'transkip.id', '=', 'nilai_transkip.transkip_id')
            ->join('mapel', 'mapel.id', '=', 'transkip.mapel_id')
            ->join('jenis_ujian', 'jenis_ujian.id', '=', 'transkip.jenis_ujian_id')
            ->select(
                'nilai_transkip.daftar_lulusan_id',
                'nama_ujian',
                'nilai_transkip.nilai_akhir',
                'mapel'
            )
            ->where('jenis_ujian.nama_ujian', 'praktek')
            ->whereIn('nilai_transkip.daftar_lulusan_id', $daftarIds)
            ->get();

        $data = [];

        foreach ($data_lulusan as $item) {
            $nilaiTulis = $data_nilai_tulis->where('daftar_lulusan_id', $item->id);
            $nilaiPraktek = $data_nilai_praktek->where('daftar_lulusan_id', $item->id);

            $data[$item->id] = [
                'lulusan'        => $item,
                'nilai_tulis'    => $nilaiTulis,
                'nilai_praktek'  => $nilaiPraktek,
                'tulis'          => $nilaiTulis->count(),
                'praktik'        => $nilaiPraktek->count(),
            ];
        }

        return view('validasi.blangko-transkip', [
            'data'          => $data,
            'lulusan'       => $lulusan,
            'data_lulusan'  => $data_lulusan,
            'dataLulusan'   => $dataLulusan,
            'kepalaSekolah' => $kepalaSekolah,
            'dataKelas'     => $dataKelas,
            'dataPeriode'   => $dataPeriode,
        ]);
    }
    public function ValidasiKelulusan(Request $request)
    {
        $tahun = $request->tahun;
        $tab = $request->tab ?? 'all';
        $tahunSekarang = Carbon::now()->year;

        $listTahun = Nis::query()
            ->selectRaw('YEAR(tanggal_masuk) as tahun')
            ->groupByRaw('YEAR(tanggal_masuk)')
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        $query = Nis::query()
            ->join('siswa', 'siswa.id', '=', 'nis.siswa_id')
            ->leftJoin('pesertakelas', 'pesertakelas.siswa_id', '=', 'siswa.id')
            ->leftJoin('daftar_lulusan', 'daftar_lulusan.pesertakelas_id', '=', 'pesertakelas.id')
            ->leftJoin('lulusan', 'lulusan.id', '=', 'daftar_lulusan.lulusan_id')
            ->selectRaw("
            siswa.id as siswa_id,
            siswa.nama_siswa,
            nis.nis,
            nis.madrasah_diniyah,
            YEAR(nis.tanggal_masuk) as tahun_masuk,
            MAX(YEAR(lulusan.tanggal_kelulusan)) as tahun_lulus,
            MAX(daftar_lulusan.nomor_ijazah) as nomor_ijazah
        ")
            ->groupBy(
                'siswa.id',
                'siswa.nama_siswa',
                'nis.nis',
                'nis.madrasah_diniyah',
                'nis.tanggal_masuk'
            );

        if ($tahun) {
            $query->whereYear('nis.tanggal_masuk', $tahun);
        }

        $validasiKelulusan = $query
            ->orderBy('tahun_masuk', 'desc')
            ->get()
            ->map(function ($item) use ($tahunSekarang) {

                $minimalStudi = match ($item->madrasah_diniyah) {
                'Ula' => 3,
                    'Wustho', 'Ulya' => 3,
                    default => 3,
                };

                $item->minimal_studi = $minimalStudi;
                $item->masa_berjalan = $tahunSekarang - $item->tahun_masuk;

                $punyaIjazah = filled($item->nomor_ijazah);
                $sudahLulus = filled($item->tahun_lulus);

            /*
|--------------------------------------------------------------------------
| VALIDASI NIS BERDASARKAN JENJANG
|--------------------------------------------------------------------------
*/

            $nisValid = true;
            $item->tahun_nis = '';

            switch ($item->madrasah_diniyah) {

                case 'Ula':

                    // Format : 2503044
                    // 25 = Tahun
                    // 03 = Kode Ula
                    // 044 = Nomor Urut

                    if (strlen($item->nis) != 7) {

                        $nisValid = false;
                    } else {

                        $item->tahun_nis = '20' . substr($item->nis, 0, 2);

                        if ($item->tahun_nis != $item->tahun_masuk) {
                            $nisValid = false;
                        }

                        if (substr($item->nis, 2, 2) != '03') {
                            $nisValid = false;
                        }
                    }

                    break;

                case 'Wustho':

                    // Format : 20240200087
                    // 2024 = Tahun
                    // 02 = Kode Wustho
                    // 00087 = Nomor Urut

                    if (strlen($item->nis) != 11) {

                        $nisValid = false;
                    } else {

                        $item->tahun_nis = substr($item->nis, 0, 4);

                        if ($item->tahun_nis != $item->tahun_masuk) {
                            $nisValid = false;
                        }

                        if (substr($item->nis, 4, 2) != '02') {
                            $nisValid = false;
                        }
                    }

                    break;

                case 'Ulya':

                    // Format : 20250100015
                    // 2025 = Tahun
                    // 01 = Kode Ulya
                    // 00015 = Nomor Urut

                    if (strlen($item->nis) != 11) {

                        $nisValid = false;
                    } else {

                        $item->tahun_nis = substr($item->nis, 0, 4);

                        if ($item->tahun_nis != $item->tahun_masuk) {
                            $nisValid = false;
                        }

                        if (substr($item->nis, 4, 2) != '01') {
                            $nisValid = false;
                        }
                    }

                    break;

                default:

                    $nisValid = false;
                    break;
            }
                $item->lama_studi = null;
                $layakLulus = $item->masa_berjalan >= $minimalStudi;

                /*
            |--------------------------------------------------------------------------
            | VALID
            |--------------------------------------------------------------------------
            */
                if ($sudahLulus && $punyaIjazah) {
                    $item->lama_studi = $item->tahun_lulus - $item->tahun_masuk;

                    if ($item->lama_studi < $minimalStudi) {
                        $item->status = 'warning';
                        $item->keterangan = 'Lulus terlalu cepat';
                    } else {
                        $item->status = 'valid';
                        $item->keterangan = !$nisValid
                            ? 'Valid (cek NIS)'
                            : 'Valid';
                    }

                    return $item;
                }

                /*
            |--------------------------------------------------------------------------
            | WARNING
            |--------------------------------------------------------------------------
            */
                if ($layakLulus && !$punyaIjazah) {
                    $item->status = 'warning';
                    $item->keterangan = !$nisValid
                        ? 'NIS tidak sesuai & ijazah belum ada'
                        : 'Sudah layak lulus, ijazah belum ada';

                    return $item;
                }

                /*
            |--------------------------------------------------------------------------
            | PROSES
            |--------------------------------------------------------------------------
            */
                $item->status = 'proses';
                $item->keterangan = !$nisValid
                    ? 'Cek tahun NIS'
                    : 'Masih aktif';

                return $item;
            });

        return view('validasi.kelulusan', compact(
            'validasiKelulusan',
            'listTahun',
            'tahun',
            'tab'
        ));
    }
    public function pdf()
    {
        // 
        'dd';
    }
}
