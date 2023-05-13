<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


class MapelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datakelas = Kelas::all();
        $Pelajara = Mapel::query()
            ->leftjoin('kelas', 'kelas.id', '=', 'mapel.kelas_id')
            ->leftjoin('periode', 'periode.id', '=', 'mapel.periode_id')
            ->leftjoin('semester', 'semester.id', '=', 'periode.semester_id')
            ->select('mapel.*', 'kelas.kelas', 'periode', 'ket_semester')
            ->where('mapel.periode_id', session('periode_id'))
            ->OrderBy('kelas')
            ->OrderBy('mapel')
            ->get();
        return view(
            'mapel/mapel',
            [
                'listmapel' => $Pelajara,
                'datakelas' => $datakelas,
               
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
        $dataPeriode = Periode::query()
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->select('periode.id', 'periode.periode', 'semester.ket_semester')
            ->orderby('ket_semester', 'desc')
            ->where('periode.id', session('periode_id'))
            ->get();
        $datakelas = Kelas::all();
        return view('mapel/addmapel', [
            'datakelas' => $datakelas,
            'dataPeriode' => $dataPeriode
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $mapel = new Mapel();
        $mapel->mapel = $request->mapel;
        $mapel->nama_kitab = $request->nama_kitab;
        $mapel->kelas_id = $request->kelas_id;
        $mapel->periode_id = $request->periode_id;
        $mapel->save();
        return redirect()->back()->with('success', 'berhasil menambahkan data ini');
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
    public function edit(Mapel $mapel)
    {
        $datakelas = Kelas::all();
        $dataPeriode = Periode::query()
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->select('periode.id', 'periode.periode', 'semester.ket_semester')
            ->orderby('ket_semester', 'desc')
            // ->where('periode.id', session('periode_id'))
            ->get();
        return view('mapel.editmapel', compact('datakelas', 'mapel', 'dataPeriode'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mapel $mapel)
    {
        Mapel::where('id', $mapel->id)
            ->update([
                'mapel' => $request->mapel,
                'nama_kitab' => $request->nama_kitab,
                'kelas_id' => $request->kelas_id,
                'periode_id' => $request->periode_id,
            ]);
        return redirect('/mapel')->with('update', 'berhasil diperbaharui data ini');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mapel $mapel)
    {
        Mapel::destroy($mapel->id);
        return redirect()->back()->with('delete', 'berhasil menghapus data ini');
    }
}
