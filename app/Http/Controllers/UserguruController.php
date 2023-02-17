<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserguruController
{
    public function DashboardGuru()
    {
        return view('guru.dashboard.gurudashboard');
    }
    public function UserGuru()
    {
        $guru_id = Auth::user()->guru_id;
        $title =  Guru::join('nig', 'guru.id', '=', 'nig.guru_id')
            ->where('guru.id', $guru_id)
            ->first();
        $userGuru = Guru::query()
            ->leftjoin('nig', 'nig.guru_id', '=', 'guru.id')
            ->leftjoin('nilaimapel', 'nilaimapel.guru_id', '=', 'guru.id')
            ->leftjoin('mapel', 'mapel.id', '=', 'nilaimapel.mapel_id')
            ->leftjoin('kelasmi', 'kelasmi.id', '=', 'nilaimapel.kelasmi_id')
            ->join('periode', 'periode.id', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', 'periode.semester_id')
            ->select([
                'nilaimapel.id',
                'nama_kelas',
                'mapel',
                'nama_kitab',
                'periode',
                'ket_semester'
            ])
            ->where('kelasmi.periode_id', session('periode_id'))
            ->where('guru.id', $guru_id)
            ->orderby('nama_kelas')->get();
        return view(
            'guru/dashboard/nilaiperguru',
            [
                'dataguru' => $userGuru,
                'title' => $title
            ]
        );
    }
}
