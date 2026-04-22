<?php

namespace App\Http\Controllers;

use App\Models\Asramasiswa;
use App\Models\Kegiatan;
use App\Models\Periode;
use App\Models\Pesertaasrama;
use App\Models\Presensiasrama;
use App\Models\Sesiasrama;
use Carbon\Exceptions\InvalidFormatException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SesiasramaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Sesiasrama $sesiasrama)
    {
        try {
            $tanggal = $request->tanggal ? Carbon::parse($request->tanggal) : now();
        } catch (InvalidFormatException $ex) {
            $tanggal = now();
        }
        $peserta = Presensiasrama::all();
        $update_terakhir = $peserta->max('updated_at');
        $create_at = $peserta->max('create_at');
        $asramasiswa = Asramasiswa::query()
            ->join('asrama', 'asrama.id', '=', 'asramasiswa.asrama_id')
            ->join('periode', 'periode.id', '=', 'asramasiswa.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->select('asramasiswa.id', 'asrama.nama_asrama', 'semester.ket_semester')
            ->where('asramasiswa.periode_id', session('periode_id'))
            ->orderby('type_asrama')
            ->orderby('nama_asrama')
            ->get();
        $periode = Periode::query()
            ->join('semester', 'periode.semester_id', '=', 'semester.id')
            ->select('periode.id', 'periode.periode', 'semester.ket_semester')
            ->where('periode.id', session('periode_id'))
        ->orderBy('id', 'desc')->get();
        $kegiatan = Kegiatan::all();
        // $tanggal = $request->tgl ? Carbon::parse($request->tgl) : now();
        $Datasesiasrama = Sesiasrama::query()
            ->join('periode', 'periode.id', '=', 'sesiasrama.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->join('kegiatan', 'kegiatan.id', '=', 'sesiasrama.kegiatan_id')
            ->join('asramasiswa', 'asramasiswa.id', '=', 'sesiasrama.asramasiswa_id')
            
            ->join('asrama', 'asrama.id', '=', 'asramasiswa.asrama_id')
            ->where('sesiasrama.periode_id', session('periode_id'))
            ->where('sesiasrama.tanggal', $tanggal->toDateString())
            ->select(
                [
                    'sesiasrama.id',
                    'periode.periode',
                    'sesiasrama.tanggal',
                    'semester.ket_semester',
                    'asrama.nama_asrama',
                'asrama.type_asrama',
                'kegiatan.kegiatan',
                
                
                ]
        )
        ->orderBy('tanggal')
        ->orderBy('kegiatan')
        ->orderBy('type_asrama')
        ->orderBy('nama_asrama');
        if (request('tanggal')) {
            $Datasesiasrama->where('tanggal', 'like', '%' . request('cari') . '%');
        }
        
        return view(
            'presensi/asrama/sesiasrama',
            [
                'periode' => $periode,
                'asramasiswa' => $asramasiswa,
                'sesiasrama' => $sesiasrama,
                'Datasesiasrama' => $Datasesiasrama->get(),
                'kegiatan' => $kegiatan,
                'update_terakhir' => $update_terakhir,
                'create_at' => $create_at,
                'tanggal' => $tanggal,
               
            ]
        );
    }


    public function store(Request $request)
    {
        // ✅ VALIDASI

        $validated = $request->validate([
            'tanggal' => 'required|date',
            'periode_id' => 'required|exists:periode,id',
            'asramasiswa_id' => 'required|exists:asramasiswa,id',
            'kegiatan_id' => 'required|exists:kegiatan,id',
        ]);

        try {
            $sesiasrama = new Sesiasrama();
            $sesiasrama->tanggal = $validated['tanggal'];
            $sesiasrama->periode_id = $validated['periode_id'];
            $sesiasrama->asramasiswa_id = $validated['asramasiswa_id'];
            $sesiasrama->kegiatan_id = $validated['kegiatan_id'];
            $sesiasrama->save();

            // ✅ NOTIF SUKSES
            return redirect('sesiasrama')->with('success', 'Data berhasil disimpan!');
        } catch (\Throwable $e) {

            // ✅ SIMPAN LOG ERROR (penting untuk debug)
            Log::error('Error simpan sesi asrama: ' . $e->getMessage());

            // ❌ NOTIF ERROR
            return back()->with('error', 'Terjadi kesalahan saat menyimpan data!')->withInput();
        }
    }

    
    public function show(Sesiasrama $sesiasrama)
    {

        $presensi = Sesiasrama::query()
            ->join('kegiatan', 'kegiatan.id', '=', 'sesiasrama.kegiatan_id')
            ->join('periode', 'periode.id', '=', 'sesiasrama.periode_id')
        ->join('semester', 'semester.id', '=', 'periode.semester_id')
        ->join('asramasiswa', 'asramasiswa.id', 'sesiasrama.asramasiswa_id')
        ->join('asrama', 'asrama.id', 'asramasiswa.asrama_id')
        ->find($sesiasrama)->first();
        $peserta = Pesertaasrama::query()
            ->join('siswa', 'siswa.id', '=', 'pesertaasrama.siswa_id')
            ->join('asramasiswa', 'asramasiswa.id', '=', 'pesertaasrama.asramasiswa_id')
            ->leftJoin('presensiasrama', function ($join) use ($sesiasrama) {
                $join->on('presensiasrama.pesertaasrama_id', '=', 'pesertaasrama.id')
                    ->where('presensiasrama.sesiasrama_id', $sesiasrama->id);
            })
            ->join('asrama', 'asrama.id', '=', 'asramasiswa.asrama_id')
            ->select(
                [
                    'siswa.nama_siswa',
                    'asrama.nama_asrama',
                    'asramasiswa.asrama_id',
                    'pesertaasrama.id',
                    'presensiasrama.id as presensiasrama_id',
                    'presensiasrama.keterangan',
                    'presensiasrama.updated_at'
                ]
            )
            ->where('asramasiswa.id', $sesiasrama->asramasiswa_id)
            ->get();
        $update_terakhir = $peserta->max('updated_at');
        $create_at = $peserta->max('create_at');
        return view(
            'presensi/asrama/presensiasrama',
            [
                'sesiasrama' => $sesiasrama,
                'presensi' => $presensi,
                'peserta' => $peserta,
                'update_terakhir' => $update_terakhir,
                'create_at' => $create_at
            ]
        );
    }

    
    public function edit($id)
    {
        //
    }
    public function destroy(Sesiasrama $sesiasrama)
    {

        Sesiasrama::destroy($sesiasrama->id);
        // Presensiasrama::where('asramasiswa_id', $sesiasrama->id)->delete();
        return redirect()->back();
    }

    public function simpanpresensi(Request $request)
    {
        // ❌ HAPUS dd('ok') karena bikin proses berhenti

        // ✅ VALIDASI
        $request->validate([
            'sesiasrama_id' => 'required|exists:sesiasrama,id',
            'keterangan' => 'required|array',
        ]);

        try {

            DB::beginTransaction();

            foreach ($request->keterangan as $pesertaasrama_id => $keterangan) {

                // ✅ DEFAULT AMAN
                $keterangan = in_array($keterangan, ['hadir', 'izin', 'sakit', 'alfa'])
                    ? $keterangan
                    : 'hadir';

                $alasan = $request->alasan[$pesertaasrama_id] ?? null;

                // ✅ LANGSUNG UPDATE ATAU INSERT (tanpa hidden id)
                Presensiasrama::updateOrCreate(
                    [
                        'sesiasrama_id' => $request->sesiasrama_id,
                        'pesertaasrama_id' => $pesertaasrama_id,
                    ],
                    [
                        'keterangan' => $keterangan,
                        'alasan' => $alasan,
                    ]
                );
            }

            DB::commit();

            return back()->with('success', '✅ Presensi berhasil disimpan!');
        } catch (\Throwable $e) {

            DB::rollBack();

            Log::error('Error simpan presensi: ' . $e->getMessage());

            return back()->with('error', '❌ Gagal menyimpan presensi!')->withInput();
        }
    }
}
