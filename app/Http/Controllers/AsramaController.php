<?php

namespace App\Http\Controllers;

use App\Models\Asrama;
use Illuminate\Http\Request;

class AsramaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $DataKelas = Asrama::all();
        return view('asrama/asrama', ['DataKelas' => $DataKelas]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('asrama/addasrama');
    }
    public function store(Request $request)
    {
        $asrama = new Asrama();
        $asrama->nama_asrama = $request->nama_asrama;
        $asrama->type_asrama = $request->type_asrama;
        $asrama->save();
        return redirect('asrama');
    }
    public function destroy(Asrama $asrama)
    {
        Asrama::destroy($asrama->id);
        return redirect()->back();
    }
}
