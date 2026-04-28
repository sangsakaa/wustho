<?php

namespace App\Console\Commands;

use App\Models\Periode;
use Illuminate\Console\Command;

class SetActivePeriode extends Command
{
    protected $signature = 'periode:set-active';
    

    protected $description = 'Command description';

    public function handle()
    {
        //
        $tahunAktif = $this->ask('Masukkan periode aktif (contoh: 2024/2025)');

        // Nonaktifkan semua
        Periode::query()->update(['is_active' => false]);

        // Aktifkan periode yang dipilih
        Periode::where('periode', $tahunAktif)->update(['is_active' => true]);

        $this->info("Periode $tahunAktif berhasil diaktifkan!");
    }
}
