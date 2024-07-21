<?php

namespace App\Http\Controllers;

use App\Models\Nilai;
use App\Models\Siswa;
use App\Models\Kelasmi;
use App\Models\Semester;
use App\Models\Perangkat;
use App\Models\Nilaimapel;
use App\Models\Absensikelas;
use App\Models\Pesertakelas;
use Illuminate\Http\Request;

use App\Models\Presensikelas;
use Illuminate\Routing\Controller;
use Alkoumi\LaravelHijriDate\Hijri;
use function PHPUnit\Framework\isEmpty;

class RaportController extends Controller
{
    
    public function show(Pesertakelas $pesertakelas)
    {
        $siswa = Pesertakelas::query()
            ->join('siswa', 'pesertakelas.siswa_id', '=', 'siswa.id')
            ->join('nis', 'nis.siswa_id', '=', 'siswa.id')
            ->join('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
            ->join('kelas', 'kelas.id', '=', 'kelasmi.kelas_id')
            ->join('periode', 'periode.id', '=', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->leftJoin('presensikelas', 'presensikelas.pesertakelas_id', '=', 'pesertakelas.id')
            // ->join('semester', 'semester.id', '=', 'kelasmi.periode_id')
            // ->select('kelas.kelas', 'siswa.nama_siswa', 'periode.periode', 'periode.ket_periode', 'semester.semester')
            ->where('pesertakelas.id', $pesertakelas->id)->first();
        $dataraportkelas = Nilaimapel::query()
            ->join('nilai', 'nilai.nilaimapel_id', '=', 'nilaimapel.id')
            // ->join('siswa', 'siswa.id', '=', 'nilai.siswa_id')
            ->join('mapel', 'mapel.id', '=', 'nilaimapel.mapel_id')
            ->join('guru', 'guru.id', '=', 'nilaimapel.guru_id')
            ->where('nilaimapel.kelasmi_id', $siswa->kelasmi_id)
            ->get();

        $ringkasanraportkelas = $dataraportkelas
            ->groupBy('pesertakelas_id')
            ->map(function ($item, $key) {
                $item = collect($item);
                $jmlujian = $item->sum('nilai_ujian');
                $jmlharian = $item->sum('nilai_harian');
                $rata2ujian = $jmlujian / $item->count();
                $rata2harian = $jmlharian / $item->count();
                $nilaiperingkat = $rata2ujian * 0.4 + $rata2harian * 0.6;

                return [
                    'id' => $key,
                    'jmlujian' => $jmlujian,
                    'jmlharian' => $jmlharian,
                    'rata2ujian' => $rata2ujian,
                    'rata2harian' => $rata2harian,
                    'nilaiperingkat' => $nilaiperingkat
                ];
            });

        $peringkatpeserta = $ringkasanraportkelas
            ->sortByDesc('nilaiperingkat')
            ->values()
            ->search(function ($item, $key) use ($pesertakelas) {
                return $item['id'] == $pesertakelas->id;
            }) + 1;

        $dataraport = $dataraportkelas->where("pesertakelas_id", $pesertakelas->id);
        $ringkasanraportpeserta = $ringkasanraportkelas[$pesertakelas->id];

        return view(
            'report/report',
            [
                'siswa' => $siswa,
                'data' => $dataraport,
                'ringkasan' => $ringkasanraportpeserta,
                'peringkat' => $peringkatpeserta,
                'jumlahsiswa' => $ringkasanraportkelas->count()
            ]
        );
    }

    public function raportkelas(Request $request)
    {
        setlocale(LC_TIME, 'id_ID');

        // Dapatkan tanggal Hijriyah saat ini
        // $hijriDate = Hijri::Date('l, j F o');
        $hijriDate = Hijri::Date(' j F o');
        // Buat terjemahan dari nama-nama bulan dan hari dalam bahasa Arab ke bahasa Indonesia
        $translations = [
            '١' => '1',
            '٢' => '2',
            '٣' => '3',
            '٤' => '4',
            '٥' => '5',
            '٦' => '6',
            '٧' => '7',
            '٨' => '8',
            '٩' => '9',
            '٠' => '0',
            'محرّم' => 'Muharram',
            'صفر' => 'Safar',
            'ربيع الأول' => 'Rabiul Awal',
            'ربيع الآخر' => 'Rabiul Akhir',
            'جمادى الأولى' => 'Jumadil Awal',
            'جمادى الآخرة' => 'Jumadil Akhir',
            'رجب' => 'Rajab',
            'شعبان' => 'Sya\'ban',
            'رمضان' => 'Ramadhan',
            'شوال' => 'Syawal',
            'ذو القعدة' => 'Dzulqa\'dah',
            'ذو الحجة' => 'Dzulhijjah',
            'السبت' => 'Sabtu',
            'الأحد' => 'Minggu',
            'الاثنين' => 'Senin',
            'الثلاثاء' => 'Selasa',
            'الأربعاء' => 'Rabu',
            'الخميس' => 'Kamis',
            'الجمعة' => 'Jumat'
        ];

        // Terjemahkan tanggal Hijriyah ke dalam bahasa Indonesia
        $hijriDateInIndonesian = strtr($hijriDate, $translations);

        // Cetak tanggal Hijriyah dalam bahasa Indonesia
        // echo $hijriDateInIndonesian;

        

    
        $datakelasmi = Kelasmi::query()
            ->join('periode', 'periode.id', '=', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->select('kelasmi.id', 'kelasmi.nama_kelas', 'periode.periode', 'semester.ket_semester')
            ->where('kelasmi.periode_id', session('periode_id'))
            ->orderby('ket_semester')
            ->orderby('nama_kelas')
            ->get();

        $kelasmi = Kelasmi::query()
            ->where('periode_id', session('periode_id'))
            ->where('id', $request->kelasmi_id)
            ->first();

        if ($kelasmi) {
            $dataraportkelas = Nilaimapel::query()
                ->join('nilai', 'nilai.nilaimapel_id', '=', 'nilaimapel.id')
                ->join('mapel', 'mapel.id', '=', 'nilaimapel.mapel_id')
                ->join('guru', 'guru.id', '=', 'nilaimapel.guru_id')
                ->where('nilaimapel.kelasmi_id', $kelasmi->id)
                ->get()
                ->groupBy('pesertakelas_id');
        }

        if (!$kelasmi || $dataraportkelas->isEmpty()) {
            return view(
                'report/raportkelas',
                [
                    'siswa' => [],
                    'data' => [],
                    'ringkasanraportkelas' => [],
                    'jumlahsiswa' => 0,
                    'datakelasmi' => $datakelasmi,
                    'kelasmi' => $kelasmi
                ]
            );
        }

        $siswa = Pesertakelas::query()
            ->join('siswa', 'pesertakelas.siswa_id', '=', 'siswa.id')
            ->join('nis', 'nis.siswa_id', '=', 'siswa.id')
            ->join('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
            ->join('kelas', 'kelas.id', '=', 'kelasmi.kelas_id')
            ->join('periode', 'periode.id', '=', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->leftJoin('presensikelas', 'presensikelas.pesertakelas_id', '=', 'pesertakelas.id')
            // ->join('semester', 'semester.id', '=', 'kelasmi.periode_id')
            ->select('*', 'pesertakelas.id as peserta_id')
            ->where('kelasmi.id', $kelasmi->id)
            ->orderBy('pesertakelas.id')
            ->get();


        $ringkasanraportkelas = $dataraportkelas
            ->map(function ($item, $key) {
                $item = collect($item);
                $jmlujian = $item->sum('nilai_ujian');
                $jmlharian = $item->sum('nilai_harian');
                $rata2ujian = $jmlujian / $item->count();
                $rata2harian = $jmlharian / $item->count();
                $nilaiperingkat = $rata2ujian * 0.4 + $rata2harian * 0.6;

                return [
                    'id' => $key,
                    'jmlujian' => $jmlujian,
                    'jmlharian' => $jmlharian,
                    'rata2ujian' => $rata2ujian,
                    'rata2harian' => $rata2harian,
                    'nilaiperingkat' => $nilaiperingkat
                ];
            })
            ->sortByDesc('nilaiperingkat')
            ->values()
            ->map(function ($item, $key) {
                $item['peringkat'] = $key + 1;
                return $item;
            })
            ->keyBy('id');
        $presensi = Presensikelas::join('pesertakelas', 'pesertakelas.id', '=', 'presensikelas.pesertakelas_id')
        ->where('pesertakelas.peserta_id', $siswa);
        $dataKelas = Kelasmi::query()
            ->join('kelas', 'kelas.id', '=', 'kelasmi.kelas_id')
            ->where('kelasmi.periode_id', session('periode_id'))
            ->where('kelas.kelas', 3)
            ->select('kelasmi.id', 'nama_kelas', 'jenjang')
            ->orderby('nama_kelas')
            ->get();
        $kepalaSekolah = Perangkat::query()
            ->join('jabatan_perangkat', 'jabatan_perangkat.perangkat_id', 'perangkat.id')
            ->join('jabatan', 'jabatan.id', 'jabatan_perangkat.jabatan_id')
            ->where('nama_jabatan', 'Kepala Sekolah')->first();
        // dd($siswa);
        return view(
            'report/raportkelas',
            [
                'siswa' => $siswa,
                'data' => $dataraportkelas,
                'ringkasanraportkelas' => $ringkasanraportkelas,
                'jumlahsiswa' => $ringkasanraportkelas->count(),
                'datakelasmi' => $datakelasmi,
                'kelasmi' => $kelasmi,
                'presensi' => $presensi,
                'hijriDate' => $hijriDateInIndonesian,
                'kepalaSekolah' => $kepalaSekolah,
                'dataKelas' => $dataKelas
            ]
        );
    }

    public function peringkat(Request $request)
    {
        $datakelasmi = Kelasmi::query()
            ->join('periode', 'periode.id', '=', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->select('kelasmi.id', 'kelasmi.nama_kelas', 'periode.periode', 'semester.ket_semester')
            ->where('kelasmi.periode_id', session('periode_id'))
            ->orderby('ket_semester')
            ->orderby('nama_kelas')
            ->get();

        $kelasmi = Kelasmi::query()
            ->join('periode', 'periode.id', '=', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->select('kelasmi.id', 'kelasmi.nama_kelas', 'periode.periode', 'semester.ket_semester')
            ->where('kelasmi.periode_id', session('periode_id'))
            ->where('kelasmi.id', $request->kelasmi_id)
            ->first();

        if ($kelasmi) {
            $dataraportkelas = Nilaimapel::query()
                ->join('nilai', 'nilai.nilaimapel_id', '=', 'nilaimapel.id')
                ->join('mapel', 'mapel.id', '=', 'nilaimapel.mapel_id')
                ->join('guru', 'guru.id', '=', 'nilaimapel.guru_id')
                ->where('nilaimapel.kelasmi_id', $kelasmi->id)
                ->get()
                ->groupBy('pesertakelas_id');
        }

        if (!$kelasmi || $dataraportkelas->isEmpty()) {
            return view(
                'pengaturan/peringkat',
                [
                    'siswa' => [],
                    'data' => [],
                    'ringkasanraportkelas' => [],
                    'jumlahsiswa' => 0,
                    'datakelasmi' => $datakelasmi,
                    'kelasmi' => $kelasmi
                ]
            );
        }

        $siswa = Pesertakelas::query()
            ->join('siswa', 'pesertakelas.siswa_id', '=', 'siswa.id')
            ->join('nis', 'nis.siswa_id', '=', 'siswa.id')
            ->join('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
            ->join('kelas', 'kelas.id', '=', 'kelasmi.kelas_id')
            ->join('periode', 'periode.id', '=', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->leftJoin('presensikelas', 'presensikelas.pesertakelas_id', '=', 'pesertakelas.id')
            // ->join('semester', 'semester.id', '=', 'kelasmi.periode_id')
            ->select('*', 'pesertakelas.id as peserta_id')
            ->where('kelasmi.id', $kelasmi->id)
            ->orderBy('pesertakelas.id')
            ->get()
            ->keyBy(function ($item, $key) {
                return $item->peserta_id;
            });


        $ringkasanraportkelas = $dataraportkelas
            ->map(function ($item, $key) {
                $item = collect($item);
                $jmlujian = $item->sum('nilai_ujian');
                $jmlharian = $item->sum('nilai_harian');
                $rata2ujian = $jmlujian / $item->count();
                $rata2harian = $jmlharian / $item->count();
                $nilaiperingkat = $rata2ujian * 0.4 + $rata2harian * 0.6;

                return [
                    'id' => $key,
                    'jmlujian' => $jmlujian,
                    'jmlharian' => $jmlharian,
                    'rata2ujian' => $rata2ujian,
                    'rata2harian' => $rata2harian,
                    'nilaiperingkat' => $nilaiperingkat
                ];
            })
            ->sortByDesc('nilaiperingkat')
            ->values()
            ->map(function ($item, $key) {
                $item['peringkat'] = $key + 1;
                return $item;
            })
            ->keyBy('id');
        $presensi = Presensikelas::join('pesertakelas', 'pesertakelas.id', '=', 'presensikelas.pesertakelas_id')
            ->where('pesertakelas.peserta_id', $siswa);
        
        return view(
            'pengaturan/peringkat',
            [
                'siswa' => $siswa,
                'data' => $dataraportkelas,
                'ringkasanraportkelas' => $ringkasanraportkelas,
                'jumlahsiswa' => $ringkasanraportkelas->count(),
                'datakelasmi' => $datakelasmi,
                'kelasmi' => $kelasmi,
                'presensi' => $presensi
            ]
        );
    }
}