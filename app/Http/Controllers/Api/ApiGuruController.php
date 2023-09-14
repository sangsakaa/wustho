<?php

namespace App\Http\Controllers\Api;

use App\Models\Guru;
use Illuminate\Http\Request;

class ApiGuruController
{
    public function getDataGuru()
    {
        $data = Guru::all();
        return response(['guru' => $data]);
    }
}
