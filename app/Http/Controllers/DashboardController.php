<?php

namespace App\Http\Controllers;

use App\Models\Asrama;
use App\Models\Asramasiswa;
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

        $data = Asramasiswa::query()
            ->join('asrama', 'asrama.id', '=', 'asramasiswa.asrama_id')->get();
        return view('dashboard', compact('data'));
    }

    
    
}
