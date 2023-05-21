<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QrcodeController
{
    public function Scan()
    {
        return view('presensi.asrama.Qrsesiasrama');
    }
}
