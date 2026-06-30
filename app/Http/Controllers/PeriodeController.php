<?php

namespace App\Http\Controllers;

use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeriodeController
{
    public function setActive(Request $request)
    {
        $request->validate([
            'periode_id' => 'required|exists:periode,id',
        ]);

        DB::transaction(function () use ($request) {

            Periode::query()->update([
                'is_active' => false
            ]);

            Periode::where('id', $request->periode_id)
                ->update([
                    'is_active' => true
                ]);
        });

        session([
            'periode_id' => $request->periode_id
        ]);

        return back()->with('success', 'Periode aktif berhasil diubah.');
    }
}
