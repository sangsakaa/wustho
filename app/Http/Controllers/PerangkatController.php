<?php

namespace App\Http\Controllers;

use App\Models\Perangkat;
use Illuminate\Http\Request;

class PerangkatController
{
    public function index()
    {
        $dataPerangkat = Perangkat::all();

        return view('perangkat.index', compact('dataPerangkat'));
    }
    public function create()
    {
        return view('perangkat.create');
    }
    public function store(Request $request)
    {
        $perankat = new Perangkat();
        $perankat->nama_perangkat = $request->nama_perangkat;
        $perankat->jenis_kelamin = $request->jenis_kelamin;
        $perankat->agama = $request->agama;
        $perankat->tempat_lahir = $request->tempat_lahir;
        $perankat->tanggal_lahir = $request->tanggal_lahir;
        $perankat->tanggal_masuk = $request->tanggal_masuk;
        $perankat->status = $request->status;
        $perankat->save();
        return redirect('data-perangkat')->with('success', 'data berhasil ditambahkan');
    }
}
