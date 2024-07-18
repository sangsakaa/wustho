<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Kelas;
use App\Models\Nilai;
use App\Models\Kelasmi;
use App\Models\Periode;
use App\Models\Semester;
use App\Models\Nilaimapel;
use App\Models\Pesertakelas;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class PengaturanController extends Controller
{
    public function pengaturan()
    {

        $raport = Pesertakelas::query()
            ->leftjoin('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
            ->leftJoin('kelas', 'kelas.id', '=', 'kelasmi.kelas_id')
            ->leftjoin('periode', 'periode.id', '=', 'kelasmi.periode_id')
            ->leftjoin('semester', 'semester.id', '=', 'periode.semester_id')
            ->join('siswa', 'siswa.id', '=', 'pesertakelas.siswa_id')
        ->where('kelasmi.periode_id', session('periode_id'))
        ->select(
            [
                'pesertakelas.id',
                'siswa.nama_siswa',
                'kelasmi.nama_kelas',
                'kelas.kelas',
                'periode.periode',
                'semester.semester',
                'semester.ket_semester',
            ]
        )
            ->orderby('kelas')
            ->orderby('nama_kelas')
            ->orderby('nama_siswa');
        if (request('cari')) {
            $raport->where('nama_siswa', 'like', '%' . request('cari') . '%');
        }
        return view(
            'pengaturan/pengaturan',
            [
                'raport' => $raport->paginate(10)
            ]
        );
    }
    // Controller Periode
    public function periode()
    {
        $semester = Semester::query()
            ->get();
        $periode = Periode::query()
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->select('periode.id', 'periode.periode', 'semester.semester', 'semester.ket_semester', 'tahun_hijriyah')
            ->get();
        return view(
            'pengaturan/periode',
            [
                'periode' => $periode,
                'semester' => $semester
            ]
        );
    }
    public function storeperiode(Request $request)
    {
        $periode = new Periode();
        $periode->periode = $request->periode;
        $periode->semester_id = $request->semester_id;
        $periode->save();
        return redirect()->back();
    }
    public function deleteperiode(Periode $periode)
    {
        Periode::destroy($periode->id);
        return redirect()->back();
    }

    public function semester()
    {
        $peserta = Pesertakelas::query()
            ->join('siswa', 'siswa.id', '=', 'pesertakelas.siswa_id')
            ->join('nis', 'siswa.id', '=', 'nis.siswa_id')
            ->join('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
            ->leftjoin('kelas', 'kelasmi.id', '=', 'kelasmi.kelas_id')
            ->select('siswa.nama_siswa', 'kelasmi.nama_kelas', 'nis.nis')
            ->orderBy('kelasmi.nama_kelas')
            ->orderBy('siswa.nama_siswa')
        ->where('kelasmi.periode_id', session('periode_id'));
        if (request('cari')) {
            $peserta->where('nama_kelas', 'like', '%' . request('cari') . '%');
        }
        return view(
            'pengaturan/semester',
            [
                'peserta' => $peserta->get()
            ]
        );
    }
    public function cardlogin(Request $request)
    {
        // dd($request);
        $kelasmi = Kelasmi::query()
            ->where('kelasmi.periode_id', session('periode_id'))
            ->orderby('nama_kelas')
            ->get();
        $peserta = Pesertakelas::query()
            ->join('siswa', 'siswa.id', '=', 'pesertakelas.siswa_id')
            ->join('nis', 'siswa.id', '=', 'nis.siswa_id')
            ->join('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
            ->leftjoin('kelas', 'kelasmi.id', '=', 'kelasmi.kelas_id')
            ->select('siswa.nama_siswa', 'kelasmi.nama_kelas', 'nis.nis')
            ->orderBy('kelasmi.nama_kelas')

        ->orderBy('siswa.nama_siswa');
        if (request('cari')) {
            $peserta->where('nama_kelas', 'like', '%' . request('cari') . '%');
        }
        
        return view(
            'pengaturan/cardlogin',
            [
                'peserta' => $peserta->get(),
                'kelasmi' => $kelasmi
            ]
        );
    }
    public function download_file()
    {

    //    
    }
    public function sap(Request $request)
    {
        $kelasmi = Kelasmi::query()
            ->join('periode', 'periode.id', '=', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->select('kelasmi.id', 'kelasmi.nama_kelas', 'periode.periode', 'semester.ket_semester', 'jenjang', 'tanggal_mulai')
            ->where('kelasmi.periode_id', session('periode_id'))
            ->where('kelasmi.id', $request->kelasmi_id)
            ->first();
        // dd($kelasmi);
        $datakelasmi = Kelasmi::query()
            ->join('periode', 'periode.id', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', 'periode.semester_id')
            ->select('kelasmi.id', 'kelasmi.nama_kelas', 'periode.periode', 'semester.ket_semester')
            ->where('kelasmi.periode_id', session('periode_id'))
            ->orderBy('kelasmi.nama_kelas')
            ->get();

        if (!$kelasmi) {
            return view('pengaturan.sap', [
                'dataKelasMi' => $datakelasmi,
                'kelasmi' => $kelasmi,
                'dataSiswa' => collect(),
                'dataMapel' => collect(),
            ]);
        }
        $dataMapel = Nilaimapel::query()
            ->join('guru', 'guru.id', '=', 'nilaimapel.guru_id')
            ->join('kelasmi', 'kelasmi.id', '=', 'nilaimapel.kelasmi_id')
            ->leftjoin('daftar_jadwal', 'daftar_jadwal.guru_id', '=', 'guru.id')
            ->leftjoin('jadwal', 'daftar_jadwal.jadwal_id', '=', 'jadwal.id') // Mengubah daftar_jadwal.id menjadi jadwal.id
            ->join('mapel', 'mapel.id', '=', 'nilaimapel.mapel_id')
        ->select(
            [
                'nilaimapel.id',
                'nama_guru', 'mapel',
                'jadwal.hari',
                'jadwal.periode_id',
                'kelasmi.periode_id',
                'jadwal.kelasmi_id',
                'jadwal.id'
            ]
        )
        ->where('nilaimapel.kelasmi_id', $kelasmi->id)
        ->where('jadwal.kelasmi_id', $kelasmi->id)
        ->where('kelasmi.periode_id', session('periode_id'))
        ->where('jadwal.periode_id', session('periode_id'))
        ->orderby('hari'); // Menggunakan get() untuk mengambil hasil

// Sekarang Anda memiliki hasil dalam variabel $dataMapel


        // dd($dataMapel);
        $dataSiswa = Pesertakelas::query()
            ->join('siswa', 'siswa.id', '=', 'pesertakelas.siswa_id')
            ->join('nis', 'siswa.id', '=', 'nis.siswa_id')
            ->join('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
            ->join('kelas', 'kelas.id', '=', 'kelasmi.kelas_id')
            ->where('pesertakelas.kelasmi_id', $kelasmi->id)
            ->select(
                'pesertakelas.id',
                'siswa.nama_siswa',
                'nis.nis',
                'kelas.kelas',
                'kelasmi.nama_kelas',
            )
            ->orderby('siswa.nama_siswa')
            ->get();
        if (request('cari')) {
            $dataMapel->where('nama_siswa', 'like', '%' . request('cari') . '%');
        }
        return view('pengaturan.sap', [
            'dataKelasMi' => $datakelasmi,
            'kelasmi' => $kelasmi,
            'dataSiswa' => $dataSiswa,
            'dataMapel' => $dataMapel->get(),
        ]);
    }

    public function plotingkelas(Request $request)
    {
        $dataKelas = Kelas::where('kelas', '<>', 3)->get();

        $dataPlotting = Nilai::query()
            ->join('nilaimapel', 'nilaimapel.id', '=', 'nilai.nilaimapel_id')
            ->join('pesertakelas', 'pesertakelas.id', '=', 'nilai.pesertakelas_id')
            ->join('siswa', 'siswa.id', '=', 'pesertakelas.siswa_id')
            ->join('kelasmi', 'kelasmi.id', '=', 'nilaimapel.kelasmi_id')
            ->join('kelas', 'kelas.id', '=', 'kelasmi.kelas_id')
            ->select('kelasmi.id', 'kelas', 'nama_siswa', 'nama_kelas', DB::raw('SUM(nilai_harian) as total_harian'), DB::raw('SUM(nilai_ujian) as total_ujian'))
            ->where('kelasmi.periode_id', session('periode_id'))
            ->where('kelas.kelas', '<>', 3)
            ->groupBy('nama_siswa', 'nama_kelas', 'kelasmi.id', 'kelas')
            ->havingRaw('(SUM(nilai_harian) + SUM(nilai_ujian)) <= 600')
            ->orderby('nama_siswa')
            ->orderby('nama_kelas');
        if (request('cari')) {
            $dataPlotting->where('kelas', 'like', '%' . request('cari') . '%');
        }
        $min = 30;
        $max = 35;
        $data = $dataPlotting->count();
        return view(
            'pengaturan.plotingkelas',
            [
                'dataPlotting' => $dataPlotting->orderby('nama_siswa')->get(),
                'datakelas' => $dataKelas,
                'data' => $data,
                'min' => $min,
                'max' => $max



            ]
        );
    }
    public function plotingJk(Request $request)
    {
        $dataKelas = Kelas::where('kelas', '<>', 3)->get();

        $dataPlotting = Nilai::query()
            ->join('nilaimapel', 'nilaimapel.id', '=', 'nilai.nilaimapel_id')
            ->join('pesertakelas', 'pesertakelas.id', '=', 'nilai.pesertakelas_id')
            ->join('siswa', 'siswa.id', '=', 'pesertakelas.siswa_id')
            ->join('kelasmi', 'kelasmi.id', '=', 'nilaimapel.kelasmi_id')
            ->join('kelas', 'kelas.id', '=', 'kelasmi.kelas_id')
            ->select('kelasmi.id', 'kelas', 'nama_siswa', 'jenis_kelamin', 'nama_kelas', DB::raw('SUM(nilai_harian) as total_harian'), DB::raw('SUM(nilai_ujian) as total_ujian'))
            ->where('kelasmi.periode_id', session('periode_id'))
            ->where('kelas.kelas', '<>', 3)
            ->groupBy('nama_siswa', 'kelasmi.id', 'kelas', 'jenis_kelamin', 'nama_kelas')
        ->havingRaw('(SUM(nilai_harian) + SUM(nilai_ujian)) <= 600');

        if (request('cari')) {
            $dataPlotting->where('kelas', 'like', '%' . request('cari') . '%');
        }

        $dataPlotting = $dataPlotting->get();
        return view(
            'pengaturan.plotingkelasJK',
            [
                'datakelas' => $dataKelas,
                'dataPlotting' => $dataPlotting,
                
            ]
        );
    }
    public function testLive()
    {
        return view('pengaturan.live');
    }
    public function kalender($year = null)
    {

        $year = $year ?: date('Y');
        $months = range(1, 12);

        $calendar = [];
        foreach ($months as $month) {
            $firstDay = Carbon::create($year, $month, 1)->locale('id_ID'); // Atur lokalitas ke bahasa Indonesia
            $lastDay = $firstDay->copy()->endOfMonth();

            $calendar[] = [
                'month' => $firstDay->translatedFormat('F'), // Menggunakan translatedFormat untuk mendapatkan nama bulan dalam bahasa Indonesia
                'days' => $this->getDaysInMonth($firstDay),
            ];
        }



        return view('pengaturan.kalender', compact('year', 'calendar'));
    }
    private function getDaysInMonth($date)
    {
        $days = [];
        $firstDay = $date->copy()->startOfMonth();
        $lastDay = $date->copy()->endOfMonth();

        while ($firstDay <= $lastDay) {
            $days[] = $firstDay->copy();
            $firstDay->addDay();
        }

        return $days;
    }
    public function deleteRecordsById(Request $request)
    {
        // Validate the input to ensure it is a valid integer
        $request->validate([
            'idsql' => 'required|integer'
        ]);

        $id = $request->input('idsql');

        // Start a database transaction
        DB::transaction(function () use ($id) {
            // Delete records from multiple tables where id is greater than or equal to the specified id
            DB::table('siswa')->where('id', '>=', $id)->delete();
            DB::table('nis')->where('siswa_id', '>=', $id)->delete();
            DB::table('statusanak')->where('siswa_id', '>=', $id)->delete();
            // Add any other related tables here if needed
        });

        // Redirect back after deletion
        return redirect()->back()->with('success', 'Records deleted successfully');
    }
    
}