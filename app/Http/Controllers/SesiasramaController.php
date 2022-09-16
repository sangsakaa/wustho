<?php

namespace App\Http\Controllers;

use App\Models\Asramasiswa;
use App\Models\Kegiatan;
use App\Models\Periode;
use App\Models\Pesertaasrama;
use App\Models\Presensiasrama;
use App\Models\Sesiasrama;
use Illuminate\Http\Request;

class SesiasramaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $asramasiswa = Asramasiswa::query()
            ->join('asrama', 'asrama.id', '=', 'asramasiswa.asrama_id')
            ->join('periode', 'periode.id', '=', 'asramasiswa.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->select('asramasiswa.id', 'asrama.nama_asrama', 'semester.ket_semester')
            ->get();
        $periode = Periode::query()
            ->join('semester', 'periode.semester_id', '=', 'semester.id')
            ->select('periode.id', 'periode.periode', 'semester.ket_semester')
            ->get();
        $kegiatan = Kegiatan::all();
        $sesiasrama = Sesiasrama::query()
            ->join('periode', 'periode.id', '=', 'sesiasrama.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->join('kegiatan', 'kegiatan.id', '=', 'sesiasrama.kegiatan_id')
            ->join('asramasiswa', 'asramasiswa.id', '=', 'sesiasrama.asramasiswa_id')
            ->join('asrama', 'asrama.id', '=', 'asramasiswa.asrama_id')
            ->select(
                [
                    'sesiasrama.id',
                    'periode.periode',
                    'sesiasrama.tanggal',
                    'semester.ket_semester',
                    'asrama.nama_asrama',
                    'kegiatan.kegiatan'
                ]
            )

            ->get();
        return view(
            'presensi/asrama/sesiasrama',
            [
                'periode' => $periode,
                'asramasiswa' => $asramasiswa,
                'sesiasrama' => $sesiasrama,
                'kegiatan' => $kegiatan
            ]
        );
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
        $sesiasrama = new Sesiasrama();
        $sesiasrama->tanggal = $request->tanggal;
        $sesiasrama->periode_id = $request->periode_id;
        $sesiasrama->asramasiswa_id = $request->asramasiswa_id;
        $sesiasrama->kegiatan_id = $request->kegiatan_id;
        $sesiasrama->save();
        return redirect('sesiasrama');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Sesiasrama $sesiasrama)
    {
        $presensi = $sesiasrama->query()
            ->join('periode', 'periode.id', '=', 'sesiasrama.periode_id')
            ->join('kegiatan', 'kegiatan.id', '=', 'sesiasrama.kegiatan_id')
            ->join('asramasiswa', 'asramasiswa.id', '=', 'sesiasrama.asramasiswa_id')
            ->crossjoin('semester')
            ->join('asrama', 'asrama.id', '=', 'asramasiswa.asrama_id')
            ->select(
                [

                    'periode.periode',
                    // 'sesiasrama.id',
                    'semester.ket_semester',
                    'asrama.nama_asrama',
                    'kegiatan.kegiatan'
                ]
            )
            ->find($sesiasrama->id);
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
        return view(
            'presensi/asrama/presensiasrama',
            [
                'sesiasrama' => $sesiasrama,
                'presensi' => $presensi,
                'peserta' => $peserta,
                'update_terakhir' => $update_terakhir
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sesiasrama $sesiasrama)
    {
        Sesiasrama::destroy($sesiasrama->id);
        // Presensiasrama::where('asramasiswa_id', $sesiasrama->id)->delete();
        return redirect()->back();
    }

    public function simpanpresensi(Request $request)
    {
        foreach ($request->pesertaasrama_id as $pesertaasrama_id) {
            $presensiasrama_id = $request->presensiasrama_id[$pesertaasrama_id];
            $presensiasrama = $presensiasrama_id ? Presensiasrama::find($presensiasrama_id) : new Presensiasrama();
            $presensiasrama->sesiasrama_id = $request->sesiasrama_id;
            $presensiasrama->pesertaasrama_id = $pesertaasrama_id;
            $presensiasrama->keterangan = $request->keterangan[$pesertaasrama_id];
            $presensiasrama->alasan = $request->alasan[$pesertaasrama_id];
            $presensiasrama->save();
        }
        return redirect()->back();
    }
}
