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
            ->where('asramasiswa.periode_id', session('periode_id'))
            ->groupBy(
                'asramasiswa.id',
                'periode',
                'ket_semester',
                'nama_asrama',
                'type_asrama',
                'kuota',
                'jumlah_peserta_asrama'
            )
            ->orderBy('type_asrama')
            ->orderBy('nama_asrama')
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
        $periode = Periode::query()
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->select('periode.id', 'ket_semester', 'periode.periode')
            ->get();
        $dataasrama = Asrama::query()
            ->orderby('type_asrama')
            ->orderby('nama_asrama')
            ->get();
        return view(
            'asrama/addasramasiswa',
            [
                'datasrama' => $dataasrama,
                'periode' => $periode
            ]
        );
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
        $asramasiswa->periode_id = session('periode_id');
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
        $tittle = Asramasiswa::query()
            ->join('asrama', 'asrama.id', '=', 'asramasiswa.asrama_id')
            ->select('asrama.nama_asrama', 'asramasiswa.kuota', 'asramasiswa.id')
        ->where('asramasiswa.id', $asramasiswa->id)->first();
        return view(
            'asrama/pesertaasrama',
            [
                'asramasiswa' => $asramasiswa,
                'tittle' => $tittle,
                
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
        $dataasrama = Asrama::query()

            ->get();

        // dd($dataasrama);
        return view(
            'asrama/editasramasiswa',
            [
                'asramasiswa' => $asramasiswa,
                'dataasrama' => $dataasrama
            ]
        );
    }
    public function editpeserta(Pesertaasrama $pesertaasrama, Asramasiswa $asramasiswa)
    {
       
        $anggota = Pesertaasrama::query()
            ->join('siswa', 'siswa.id', '=', 'pesertaasrama.siswa_id')
            ->where('pesertaasrama.id', $pesertaasrama->id)->first();
        $dataasrama = Asramasiswa::query()
            ->join('asrama', 'asrama.id', '=', 'asramasiswa.asrama_id')
            ->select('nama_asrama', 'asramasiswa.id')
            ->where('asramasiswa.periode_id', session('periode_id'))
            ->orderby('type_asrama')
            ->orderby('nama_asrama')
            ->get();
        return view(
            'asrama/editpeserta',
            [
                'anggota' => $anggota,
                'pesertaasrama' => $pesertaasrama,
                'asramasiswa' => $asramasiswa,
                'dataasrama' => $dataasrama,
            ]
        );
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
    public function updatepeserta(Request $request, Pesertaasrama $pesertaasrama)
    {
        Pesertaasrama::where('id', $pesertaasrama->id)
            ->update([
                'siswa_id' => $request->siswa_id,
                'asramasiswa_id' => $request->asramasiswa_id,

            ]);
        if (auth()->user()->hasRole('super admin')) {
            return redirect('/pesertaasrama/' . $pesertaasrama->asramasiswa_id);
        } elseif (auth()->user()->hasRole('siswa')) {
            return redirect('/user');
        }

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
    public function kolelktifasrama(Asramasiswa $asramasiswa)
    {
        $kelas = Asramasiswa::query()
            ->join('asrama', 'asrama.id', '=', 'asramasiswa.asrama_id')
            ->select('asrama.nama_asrama', 'asramasiswa.id', 'type_asrama')
            ->where('asramasiswa.periode_id', session('periode_id'))
            ->orderby('type_asrama')
            ->get();

        $pesertaAsramaPeriodeTerpilih = Pesertaasrama::query()
            ->join('asramasiswa', 'asramasiswa.id', '=', 'pesertaasrama.asramasiswa_id')
            ->where('asramasiswa.periode_id', $asramasiswa->periode_id)
            ->select('pesertaasrama.siswa_id');
        $Datasiswa = Siswa::query()
            ->leftJoin('nis', 'nis.siswa_id', '=', 'siswa.id')
            ->leftJoinSub($pesertaAsramaPeriodeTerpilih, 'peserta_asrama_periode_terpilih', function ($join) {
                $join->on('peserta_asrama_periode_terpilih.siswa_id', '=', 'siswa.id');
            })
            ->where('peserta_asrama_periode_terpilih.siswa_id', null)
            // ->whereNot('madrasah_diniyah', 'ula')
            ->select(
                [
                'nis.madrasah_diniyah',
                'siswa.jenis_kelamin',
                'siswa.nama_siswa',
                'siswa.id',
                'nis.nis',
                    'nis.tanggal_masuk'
                ]
        )
            ->orderBy('nis.madrasah_diniyah')
            ->orderBy('nis.nis')
            ->orderBy('siswa.jenis_kelamin')
        ->orderBy('siswa.nama_siswa');
        if (request('cari')) {
            $Datasiswa->where(function ($query) {
                $query->where('nis', 'like', '%' . request('cari') . '%')
                    ->orWhere('nama_siswa', 'like', '%' . request('cari') . '%');
            });
            // ->orWhere('nama_kelas', 'like', '%' . request('cari') . '%')
            // ->orWhere('nis', 'like', '%' . request('cari') . '%')
            // ->orWhere('tanggal_masuk', 'like', '%' . request('cari') . '%')
        }
        $a = $Datasiswa->count();

        // dd($Datasiswa->toSql());
        return view(
            'asrama/kolektifasrama',
            [
                'Datasiswa' => $Datasiswa->get(),
                'kelas' => $kelas,
                'a' => $a,
                'asramasiswa' => $asramasiswa
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
