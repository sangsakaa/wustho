<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Lulusan;
use App\Models\Periode;
use App\Models\Pesertakelas;
use Illuminate\Http\Request;
use App\Models\Daftar_lulusan;
use App\Models\Kelasmi;
use Illuminate\Support\Facades\DB;

class LulusanCotroller
{
    public function index()
    {
        $kelasMi = Kelasmi::query()
            ->join('kelas', 'kelas.id', '=', 'kelasmi.kelas_id')
            ->join('periode', 'periode.id', '=', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->where('kelasmi.periode_id', session('periode_id'))
            ->select('kelasmi.id', 'kelas', 'nama_kelas', 'ket_semester', 'periode')
            ->where('kelas.kelas', 3)
            ->orderBy('nama_kelas')
            ->get();

        $dataPeriode = Periode::query()
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->select('periode.id', 'periode.periode', 'semester.ket_semester')
            ->where('periode.id', session('periode_id'))
            ->orderBy('ket_semester', 'desc')
            ->get();

        $dataLulusan = Lulusan::query()
            ->join('periode', 'periode.id', '=', 'lulusan.periode_id')
            ->join('kelasmi', 'kelasmi.id', '=', 'lulusan.kelasmi_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->leftJoin('daftar_lulusan', 'daftar_lulusan.lulusan_id', '=', 'lulusan.id')
            ->where('lulusan.periode_id', session('periode_id'))
            ->select(
                'kelasmi.nama_kelas',
            'lulusan.id',
            'periode.periode',
            'semester.ket_semester',
            'lulusan.tanggal_mulai',
            'lulusan.tanggal_selesai',
            'lulusan.tanggal_kelulusan',
                'lulusan.tanggal_lulus_hijriyah',
                DB::raw('COUNT(daftar_lulusan.id) as jumlah_lulusan')
            )
            ->groupBy(
                'kelasmi.nama_kelas',
                'lulusan.id',
                'periode.periode',
                'semester.ket_semester',
                'lulusan.tanggal_mulai',
                'lulusan.tanggal_selesai',
                'lulusan.tanggal_kelulusan',
                'lulusan.tanggal_lulus_hijriyah'
            )
            ->orderBy('kelasmi.nama_kelas')
            ->get();

        // cek apakah periode aktif semester genap
        $periodeAktif = Periode::query()
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->where('periode.id', session('periode_id'))
            ->select('semester.ket_semester')
            ->first();

        $bolehLulus = $periodeAktif && strtolower($periodeAktif->ket_semester) == 'genap';
        // Dashboard Statistik
        $dashboardKelas = DB::table('lulusan')
            ->join('kelasmi', 'kelasmi.id', '=', 'lulusan.kelasmi_id')
            ->leftJoin('daftar_lulusan', 'daftar_lulusan.lulusan_id', '=', 'lulusan.id')
            ->select(
                'kelasmi.nama_kelas',
                DB::raw('COUNT(daftar_lulusan.id) as jumlah')
            )
            ->where('lulusan.periode_id', session('periode_id'))
            ->groupBy('kelasmi.nama_kelas')
            ->orderBy('kelasmi.nama_kelas')
            ->get();

        $totalLulusan = Daftar_lulusan::query()
            ->join('lulusan', 'lulusan.id', '=', 'daftar_lulusan.lulusan_id')
            ->where('lulusan.periode_id', session('periode_id'))
            ->count();

        $totalKelas = $dashboardKelas->count();

        return view('lulusan.index', [
            'dataLulusan' => $dataLulusan,
            'dataPeriode' => $dataPeriode,
            'kelasMi' => $kelasMi,
            'bolehLulus' => $bolehLulus,
            // dashboard
            'dashboardKelas' => $dashboardKelas,
            'totalLulusan' => $totalLulusan,
            'totalKelas' => $totalKelas,
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'periode_id' => 'required',
            'kelasmi_id' => 'required',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'tanggal_kelulusan' => 'required|date',
            'tanggal_lulus_hijriyah' => 'required|string|max:255',
        ], [
            'periode_id.required' => 'Periode wajib dipilih',
            'kelasmi_id.required' => 'Kelas wajib dipilih',
            'tanggal_mulai.required' => 'Tanggal mulai wajib diisi',
            'tanggal_mulai.date' => 'Format tanggal mulai tidak valid',

            'tanggal_selesai.required' => 'Tanggal selesai wajib diisi',
            'tanggal_selesai.date' => 'Format tanggal selesai tidak valid',
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai harus setelah atau sama dengan tanggal mulai',

            'tanggal_kelulusan.required' => 'Tanggal kelulusan wajib diisi',
            'tanggal_kelulusan.date' => 'Format tanggal kelulusan tidak valid',

            'tanggal_lulus_hijriyah.required' => 'Tanggal hijriyah wajib diisi',
        ]);

        $lulusan = new Lulusan();
        $lulusan->periode_id = $request->periode_id;
        $lulusan->kelasmi_id = $request->kelasmi_id;
        $lulusan->tanggal_mulai = $request->tanggal_mulai;
        $lulusan->tanggal_selesai = $request->tanggal_selesai;
        $lulusan->tanggal_kelulusan = $request->tanggal_kelulusan;
        $lulusan->tanggal_lulus_hijriyah = $request->tanggal_lulus_hijriyah;
        $lulusan->save();

        return redirect()->back()->with('success', 'Data lulusan berhasil disimpan');
    }
    public function daftarLulusan(Lulusan $lulusan, Daftar_lulusan $daftar_lulusan)
    {
        $daftarLulusan = Daftar_lulusan::query()
            ->leftjoin('pesertakelas', 'pesertakelas.id', '=', 'daftar_lulusan.pesertakelas_id')
            ->leftjoin('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
            ->leftjoin('lulusan', 'lulusan.id', '=', 'daftar_lulusan.lulusan_id')
            ->leftjoin('siswa', 'siswa.id', '=', 'pesertakelas.siswa_id')
            ->leftjoin('nis', 'siswa.id', '=', 'nis.siswa_id')
            ->select(
                [
                    'daftar_lulusan.id',
                    'daftar_lulusan.nomor_ijazah',
                'kelasmi.nama_kelas',
                'siswa.nama_siswa',
                'nis.nis',
                ]
            )
            ->where('daftar_lulusan.lulusan_id', $lulusan->id)
            ->orderby('nomor_ijazah')
            ->orderby('nama_siswa')
            ->get();
        return view(
            'lulusan.daftar',
            [
                'lulusan' => $lulusan,
                'daftarLulusan' => $daftarLulusan,
                'daftar_lulusan' => $daftar_lulusan,
            ]
        );
    }
    public function kolektifLulusan(Lulusan $lulusan,)
    {
        $daftarLulusan = Pesertakelas::query()
            ->leftjoin('daftar_lulusan', 'pesertakelas.id', '=', 'daftar_lulusan.pesertakelas_id')
            ->leftjoin('siswa', 'siswa.id', '=', 'pesertakelas.siswa_id')
            ->leftjoin('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
            ->leftjoin('kelas', 'kelas.id', '=', 'kelasmi.kelas_id')
            ->leftjoin('nis', 'siswa.id', '=', 'nis.siswa_id')
            ->select(
                [
                'pesertakelas.id',
                    'nama_siswa',
                'nama_kelas',
                'nis'

                ]
            )
            ->where('kelasmi.periode_id', session('periode_id'))
            ->where('daftar_lulusan.pesertakelas_id', '=', null)
            ->where('kelas.kelas', 3)
            ->where('pesertakelas.kelasmi_id', $lulusan->kelasmi_id)
            ->orderby('nama_kelas')
            ->orderby('nama_siswa')
            ->get();

        return view(
            'lulusan.kolektif',
            [
                'daftarLulusan' => $daftarLulusan,
                'lulusan' => $lulusan
            ]
        );
    }
    public function storeLulusan(Request $request)
    {
        $tahunHijrian = Periode::where('id', session('periode_id'))->first();
        $hijriYear = $tahunHijrian->tahun_hijriyah;

        // ambil nomor terakhir
        $lastNumber = DB::table('daftar_lulusan')->max('nomor_ijazah');

        if (is_null($lastNumber)) {
            $newNumber = 1;
        } else {
            $lastNumber = (int) substr($lastNumber, -4);
            $newNumber = $lastNumber + 1;

            if ($newNumber > 999) {
                $newNumber = 1;
            }
        }

        $jenjang = Kelasmi::first()->jenjang;

        // FIX: tambah Ulya
        $codeSegment = match ($jenjang) {
            'Wustho' => 'II',
            'Ula'    => 'I',
            'Ulya'   => 'III',
            default  => '00',
        };

        $pesertaKelas = $request->input('pesertakelas', []);

        if (count($pesertaKelas) === 0) {
            return "Tidak ada inputan";
        }

        $daftarLulusan = [];

        foreach ($pesertaKelas as $pesertaKelasId) {

            $code = 'MD-01-' . $codeSegment . '-' . $hijriYear . '-' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);

            $daftarLulusan[] = [
                'pesertakelas_id' => $pesertaKelasId,
                'lulusan_id'      => $request->lulusan_id,
                'nomor_ijazah'    => $code,
            ];

            $newNumber++;
        }

        Daftar_lulusan::insert($daftarLulusan);

        return redirect()->back();
    }
    public function Destroy(Lulusan $lulusan)
    {
        Lulusan::destroy($lulusan->id);
        Daftar_lulusan::where('lulusan_id', $lulusan->id)->delete();
        return redirect()->back();
    }
    public function DeletePeserta(Daftar_lulusan $daftar_lulusan)
    {
        Daftar_lulusan::destroy($daftar_lulusan->id);
        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }

    public function edit(Daftar_lulusan $daftar_lulusan, Pesertakelas $pesertakelas,)
    {
        return view('lulusan.edit', [
            'daftar_lulusan' => $daftar_lulusan,
            'pesertakelas' => $pesertakelas
        ]);
    }

    public function update(Request $request, Daftar_lulusan $daftar_lulusan,)
    {
        Daftar_lulusan::where('id', $daftar_lulusan->id)
            ->update([

                'nomor_ijazah' => $request->nomor_ijazah,
            ]);
        return redirect('/daftar-lulusan/' . $daftar_lulusan->lulusan_id);
    }
}
