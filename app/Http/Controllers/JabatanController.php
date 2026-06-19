<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    /**
     * Menampilkan daftar jabatan
     */
    public function index()
    {
        $dataJab = Jabatan::latest()->get();

        return view('jabatan.index', compact('dataJab'));
    }

    /**
     * Menyimpan data jabatan baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_jabatan' => 'required|string|max:255|unique:jabatan,nama_jabatan',
        ], [
            'nama_jabatan.required' => 'Nama jabatan wajib diisi.',
            'nama_jabatan.unique' => 'Nama jabatan sudah tersedia.',
        ]);

        Jabatan::create([
            'nama_jabatan' => $request->nama_jabatan,
        ]);

        return redirect()
            ->back()
            ->with('success', 'Jabatan berhasil ditambahkan.');
    }

    /**
     * Menampilkan data untuk edit
     */
    public function edit($id)
    {
        $jabatan = Jabatan::findOrFail($id);
        $dataJab = Jabatan::latest()->get();

        return view('jabatan.index', compact('jabatan', 'dataJab'));
    }

    /**
     * Update data jabatan
     */
    public function update(Request $request, $id)
    {
        $jabatan = Jabatan::findOrFail($id);

        $request->validate([
            'nama_jabatan' => 'required|string|max:255|unique:jabatan,nama_jabatan,' . $id,
        ], [
            'nama_jabatan.required' => 'Nama jabatan wajib diisi.',
            'nama_jabatan.unique' => 'Nama jabatan sudah tersedia.',
        ]);

        $jabatan->update([
            'nama_jabatan' => $request->nama_jabatan,
        ]);

        return redirect('/jabatan')
            ->with('success', 'Jabatan berhasil diperbarui.');
    }

    /**
     * Hapus data jabatan
     */
    public function destroy($id)
    {
        $jabatan = Jabatan::findOrFail($id);

        $jabatan->delete();

        return redirect()
            ->back()
            ->with('success', 'Jabatan berhasil dihapus.');
    }
}
