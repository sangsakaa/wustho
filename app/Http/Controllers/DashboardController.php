<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Asrama;
use App\Models\Asramasiswa;
use App\Models\Nis;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pa = Asrama::where('type_asrama', 'putra')->count();
        $pi = Asrama::where('type_asrama', 'putri')->count();
        $siswa = Nis::count('madrasah_diniyah', 'Wustho');
        $pr = Siswa::where('jenis_kelamin', 'p')->count();
        $lk = Siswa::where('jenis_kelamin', 'l')->count();
        $profil = Profile::first();
        $dataJumlahPeserta = Asramasiswa::query()
            ->select(['asramasiswa.id', DB::raw('count(pesertaasrama.id) as jumlah_peserta_asrama')])
            ->join('pesertaasrama', 'pesertaasrama.asramasiswa_id', '=', 'asramasiswa.id')
            ->groupBy('asramasiswa.id');
        $asrama = Asrama::all();
        $dataasrama = Asramasiswa::query()
            ->leftjoin('asrama', 'asrama.id', '=', 'asramasiswa.asrama_id')
            ->leftjoin('pesertaasrama', 'pesertaasrama.asramasiswa_id', '=', 'asramasiswa.id')
            ->leftjoinSub(
                $dataJumlahPeserta,
                'datajumlahpeserta',
                function ($join) {
                    $join->on('asramasiswa.id', '=', 'datajumlahpeserta.id');
                }
            )
            ->selectRaw('asramasiswa.id,nama_asrama,type_asrama,kuota,count(pesertaasrama.siswa_id) as jumlah_nilai_ujian, jumlah_peserta_asrama')
            ->groupBy(
                'asramasiswa.id',
                'nama_asrama',
                'type_asrama',
                'kuota',
                'jumlah_peserta_asrama'
            )
            ->get();
        // dd($data);
        return view(
            'dashboard',
            [
                'data' => $dataasrama,
                'datasrama' => $asrama,
                'profile' => $profil,
                'siswa' => $siswa,
                'pr' => $pr,
                'lk' => $lk,
                'pa' => $pa,
                'pi' => $pi,
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function JS()
    {
        
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
    public function show($id)
    {
        //
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
    public function destroy($id)
    {
        //
    }
}
