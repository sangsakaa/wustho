<?php

namespace App\Http\Controllers;

use App\Models\Kelasmi;
use App\Models\Nilai;
use App\Models\Nilaimapel;
use App\Models\Pesertakelas;
use App\Models\Presensikelas;
use App\Models\Semester;
use App\Models\Siswa;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isEmpty;

class RaportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Siswa $siswa)
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
        $datakelasmi = Kelasmi::query()
            ->join('periode', 'periode.id', '=', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->select('kelasmi.id', 'kelasmi.nama_kelas', 'periode.periode', 'semester.ket_semester')
            ->orderby('ket_semester')
            ->orderby('nama_kelas')
            ->get();

        $kelasmi = Kelasmi::find($request->kelasmi_id);

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
        return view(
            'report/raportkelas',
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

    public function peringkat(Request $request)
    {
        $datakelasmi = Kelasmi::query()
            ->join('periode', 'periode.id', '=', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->select('kelasmi.id', 'kelasmi.nama_kelas', 'periode.periode', 'semester.ket_semester')
            ->orderby('ket_semester')
            ->orderby('nama_kelas')
            ->get();

        $kelasmi = Kelasmi::find($request->kelasmi_id);

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