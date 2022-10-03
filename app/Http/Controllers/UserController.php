<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function Personal()
    {
        $siswa_id = Auth::user()->siswa_id;
        $user = Siswa::query()
            ->join('nis', 'nis.siswa_id', '=', 'siswa.id')
            ->where('siswa.id', $siswa_id)->first();
        return view('user/user', ['siswa' => $user]);
    }
}
