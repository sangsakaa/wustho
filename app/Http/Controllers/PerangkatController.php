<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use App\Models\JabatanPerangkat;
use App\Models\Perangkat;
use Illuminate\Http\Request;

class PerangkatController
{
    public function index()
    {
        // $dataPerangkat = Perangkat::all();
        $dataPerangkat = Perangkat::query()
            ->leftJoin('jabatan_perangkat', 'jabatan_perangkat.perangkat_id', '=', 'perangkat.id')
            ->leftJoin('jabatan', 'jabatan.id', '=', 'jabatan_perangkat.jabatan_id')
            ->select('jabatan.id as Jab', 'perangkat.id', 'nama_perangkat', 'status', 'jenis_kelamin', 'agama', 'tanggal_lahir', 'tempat_lahir')
            ->orderBy('jabatan_id', 'asc')
            ->orderBy('perangkat.id', 'asc')
            ->get();



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
    public function edit(Perangkat $perangkat)
    {
        return view(
            'perangkat.edit',
            [
                'perangkat' => $perangkat,

            ]
        );
    }
    public function update(Request $request, Perangkat $perangkat)
    {
        Perangkat::where('id', $perangkat->id)
            ->update([
                'nama_perangkat' => $request->nama_perangkat,
                'jenis_kelamin' => $request->jenis_kelamin,
                'agama' => $request->agama,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'tanggal_masuk' => $request->tanggal_masuk,
                'status' => $request->status,
            ]);

        return redirect()->back()->with('update', 'pembaharuan data berhasil');
    }
    public function view(Perangkat $perangkat)
    {
        $jabatan = Jabatan::all();
        $detailJab = JabatanPerangkat::query()
            ->join('perangkat', 'perangkat.id', 'jabatan_perangkat.perangkat_id')
            ->join('jabatan', 'jabatan.id', 'jabatan_perangkat.jabatan_id')
            ->where('perangkat_id', $perangkat)->first();
        return view('perangkat.detail', compact('perangkat', 'detailJab', 'jabatan'));
    }
    public function store_jabatan(request $request, $perangkat)
    {
        $perangkatId = $perangkat;
        $jabatanId = $request->jabatan_id;

        // Check if a record with the given perangkat_id already exists
        $existingJabatan = JabatanPerangkat::where('perangkat_id', $perangkatId)->first();

        if ($existingJabatan) {
            // If a record exists, update the jabatan_id
            $existingJabatan->jabatan_id = $jabatanId;
            $existingJabatan->save();
        } else {
            // If no record exists, create a new one
            $jabatan = new JabatanPerangkat();
            $jabatan->perangkat_id = $perangkatId;
            $jabatan->jabatan_id = $jabatanId;
            $jabatan->save();
        }

        return redirect()->back();
    }

    
}
