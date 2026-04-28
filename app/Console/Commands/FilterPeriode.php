<?php

namespace App\Console\Commands;

use App\Models\Periode;
use Carbon\Carbon;
use Illuminate\Console\Command;

class FilterPeriode extends Command
{
    protected $signature = 'periode:filter';

    protected $description = 'Command description';

    public function handle()
    {
        $tahunSekarang = Carbon::now()->year;
        $batas = $tahunSekarang - 3;

        $periodes = Periode::whereYear('tanggal_mulai', '>=', $batas)
            ->orWhere('is_active', true)
            ->get();

        foreach ($periodes as $p) {
            $this->line($p->periode . ' - Semester ' . $p->semester_id);
        }
    }
}
