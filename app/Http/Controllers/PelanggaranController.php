<?php

namespace App\Http\Controllers;

use App\Models\Pelanggaran;
use Illuminate\Http\Request;

class PelanggaranController
{
    public function index()
    {
    }

    public function create()
    {
        $pelanggaran = Pelanggaran::all();
        return view(
            'pelanggaran/addpelanggaran',
            [
                'pelanggaran' => $pelanggaran
            ]
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'kode_pelanggaran' => "required|max:3| min:3",
                'nama_pelanggaran' => "required",
                'type_pelanggaran' => "required",
                'poin_pelanggaran' => "required",
            ],
            [
                'kode_pelanggaran.required' => 'tidak boleh kosong wajib diisi',
                'nama_pelanggaran.required' => 'tidak boleh kosong wajib diisi',
                'type_pelanggaran.required' => 'tidak boleh kosong wajib diisi',
                'poin_pelanggaran.required' => 'tidak boleh kosong wajib diisi',
                'kode_pelanggaran.max' => 'tidak boleh lebih dari 3 karakter',
                'kode_pelanggaran.min' => 'tidak boleh kurang dari 3 karakter',
            ]
        );

        $pelanggaran = new Pelanggaran();
        $pelanggaran->kode_pelanggaran = $request->kode_pelanggaran;
        $pelanggaran->nama_pelanggaran = $request->nama_pelanggaran;
        $pelanggaran->type_pelanggaran = $request->type_pelanggaran;
        $pelanggaran->poin_pelanggaran = $request->poin_pelanggaran;
        $pelanggaran->save();
        return redirect()->back()->with('success', 'berhasil ditambah');
    }


    public function destroy(Pelanggaran $pelanggaran)
    {
        Pelanggaran::destroy($pelanggaran->id);
        return redirect()->back();
    }
}
