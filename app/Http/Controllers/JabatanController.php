<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use Illuminate\Http\Request;

class JabatanController
{
    public function index()
    {
        $dataJab = Jabatan::all();
        return view('jabatan.index', compact('dataJab'));
    }
    public function store(Request $request)
    {
        $jabatan = new Jabatan();
        $jabatan->nama_jabatan = $request->nama_jabatan;
        $jabatan->save();
        return redirect()->back();
    }
}
