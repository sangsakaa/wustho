<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Asrama;
use App\Models\Asramasiswa;
use App\Models\Periode;
use Illuminate\Http\Request;
use App\Models\Pesertaasrama;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class AsramasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataJumlahPeserta = Asramasiswa::query()
            ->select(['asramasiswa.id', DB::raw('count(pesertaasrama.id) as jumlah_peserta_asrama')])
            ->join('pesertaasrama', 'pesertaasrama.asramasiswa_id', '=', 'asramasiswa.id')
            ->groupBy('asramasiswa.id');
        $asrama = Asrama::all();
        $periode = Periode::query()
        ->join('semester', 'semester.id', '=', 'periode.semester_id')
        ->select('periode.id', 'ket_semester', 'periode.periode')
        ->get();
        $dataasrama = Asramasiswa::query()
            ->leftjoin('asrama', 'asrama.id', '=', 'asramasiswa.asrama_id')
            ->leftjoin('periode', 'periode.id', '=', 'asramasiswa.periode_id')
            ->leftjoin('semester', 'semester.id', '=', 'periode.semester_id')
            ->leftjoin('pesertaasrama', 'pesertaasrama.asramasiswa_id', '=', 'asramasiswa.id')
            ->leftjoinSub(
                $dataJumlahPeserta,
                'datajumlahpeserta',
                function ($join) {
                    $join->on('asramasiswa.id', '=', 'datajumlahpeserta.id');
                }
            )
            ->selectRaw('asramasiswa.id,nama_asrama,ket_semester,periode,type_asrama,kuota,count(pesertaasrama.siswa_id) as jumlah_nilai_ujian, jumlah_peserta_asrama')
            ->groupBy(
                'asramasiswa.id',
                'periode',
                'ket_semester',
                'nama_asrama',
                'type_asrama',
                'kuota',
                'jumlah_peserta_asrama'
            )
            ->get();
        // dd($data);
        return view(
            'asrama/asramasiswa',
            [
                'data' => $dataasrama,
                'datasrama' => $asrama,
                'periode' => $periode
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
        // $asrama = Asrama::all();
        return view('asrama/addasramasiswa');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $asramasiswa = new Asramasiswa();
        $asramasiswa->asrama_id = $request->asrama_id;
        $asramasiswa->kuota = $request->kuota;
        $asramasiswa->periode_id = $request->periode_id;
        $asramasiswa->save();
        return redirect('asramasiswa')->with('update');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Asramasiswa  $asramasiswa
     * @return \Illuminate\Http\Response
     */
    public function show(Asramasiswa $asramasiswa)
    {
        $tittle = $asramasiswa->join('asrama', 'asrama.id', '=', 'asramasiswa.asrama_id')
        ->select('asrama.nama_asrama', 'asramasiswa.kuota', 'asramasiswa.id')
        ->find($asramasiswa)->first();
        $data = Pesertaasrama::query()
            ->join('siswa', 'siswa.id', '=', 'pesertaasrama.siswa_id')
            ->join('asramasiswa', 'asramasiswa.id', '=', 'pesertaasrama.asramasiswa_id')
            ->join('asrama', 'asrama.id', '=', 'asramasiswa.asrama_id')
            ->join('nis', 'nis.siswa_id', '=', 'siswa.id')
            ->select('pesertaasrama.id', 'siswa.nama_siswa', 'asrama.nama_asrama', 'nis.nis', 'siswa.jenis_kelamin', 'siswa.kota_asal')
            ->where('asramasiswa_id', $asramasiswa->id)
            ->orderBy('nis.nis')
            ->orderBy('siswa.nama_siswa');
        if (request('cari')) {
            $data->where('nama_siswa', 'like', '%' . request('cari') . '%');
            // ->orWhere('Kota_asal', 'like', '%' . request('cari') . '%')
            // ->orWhere('nama_kelas', 'like', '%' . request('cari') . '%')
            // ->orWhere('nis', 'like', '%' . request('cari') . '%')
            // ->orWhere('tanggal_masuk', 'like', '%' . request('cari') . '%')

        }
        return view(
            'asrama/pesertaasrama',
            [
                'asramasiswa' => $asramasiswa,
                'tittle' => $tittle,
                'datapeserta' => $data->get()
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Asramasiswa  $asramasiswa
     * @return \Illuminate\Http\Response
     */
    public function edit(Asramasiswa $asramasiswa)
    {
        return view('asrama/editasramasiswa', ['asramasiswa' => $asramasiswa]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Asramasiswa  $asramasiswa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Asramasiswa $asramasiswa)
    {
        Asramasiswa::where('id', $asramasiswa->id)
            ->update([
                'asrama_id' => $request->asrama_id,
                'kuota' => $request->kuota,

            ]);
        return redirect('/asramasiswa')->with('update', 'pembaharuan data berhasil');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Asramasiswa  $asramasiswa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Asramasiswa $asramasiswa)
    {
        // dd($asramasiswa);
        Asramasiswa::destroy($asramasiswa->id);
        Pesertaasrama::where('asramasiswa_id', $asramasiswa->id)->delete();
        return redirect()->back();
    }
    public function PesertaAsrama(Pesertaasrama $pesertaasrama)
    {
        // dd($pesertaasrama);
        Pesertaasrama::destroy($pesertaasrama->id);
        return redirect()->back();
    }
    public function kolelktifasrama()
    {
        $kelas = Asramasiswa::query()
            ->join('asrama', 'asrama.id', '=', 'asramasiswa.asrama_id')
            ->select('asrama.nama_asrama', 'asramasiswa.id')
            ->get();

        $Datasiswa = Siswa::query()
            ->leftjoin('nis', 'nis.siswa_id', '=', 'siswa.id')
            ->leftjoin('pesertaasrama', 'pesertaasrama.id', '=', 'pesertaasrama.siswa_id')
            ->where('pesertaasrama.siswa_id', '=', null)
        ->select(
            [
                'siswa.id',
                'siswa.nama_siswa',
                'siswa.jenis_kelamin',
                'nis.nis',
                'nis.tanggal_masuk'
            ]
        )
        ->orderBy('nis.nis')
        ->orderBy('siswa.nama_siswa')
        ->orderBy('siswa.jenis_kelamin');
        if (request('cari')) {
            $Datasiswa->where('nis', 'like', '%' . request('cari') . '%')
            ->orWhere('nama_siswa', 'like', '%' . request('cari') . '%');
            // ->orWhere('nama_kelas', 'like', '%' . request('cari') . '%')
            // ->orWhere('nis', 'like', '%' . request('cari') . '%')
            // ->orWhere('tanggal_masuk', 'like', '%' . request('cari') . '%')

        }
        return view(
            'asrama/kolektifasrama',
            [
                'Datasiswa' => $Datasiswa->paginate(20),
                'kelas' => $kelas
            ]
        );
    }
    public function StoreKolektifasrama(Request $request)
    {
        foreach ($request->siswa as $siswa) {
            $peserta = new Pesertaasrama();
            $peserta->siswa_id = $siswa;
            $peserta->asramasiswa_id = $request->asramasiswa_id;
            $peserta->save();
        }
        return redirect()->back();
    }
}
