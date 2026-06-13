<?php

namespace App\Console\Commands;

use App\Models\Periode;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SetActivePeriode extends Command
{
    protected $signature = 'periode:set-active';

    protected $description = 'Mengaktifkan periode sistem';

    public function handle()
    {
        // Ambil semua periode
        $periodes = Periode::with('semester')
            ->orderByDesc('periode')
            ->get();

        if ($periodes->isEmpty()) {
            $this->error('Tidak ada data periode.');

            return self::FAILURE;
        }

        // Tampilkan daftar periode
        $this->info('Daftar Periode:');

        foreach ($periodes as $item) {

            $status = $item->is_active
                ? ' [AKTIF]'
                : '';

            $this->line(
                "{$item->id}. {$item->periode} - {$item->semester?->ket_semester}{$status}"
            );
        }

        // Pilih ID
        $id = $this->ask('Masukkan ID periode yang ingin diaktifkan');

        $periode = Periode::find($id);

        if (!$periode) {

            $this->error('Periode tidak ditemukan.');

            return self::FAILURE;
        }

        // Konfirmasi
        if (
            !$this->confirm(
                "Yakin mengaktifkan periode {$periode->periode} ?"
            )
        ) {

            $this->warn('Dibatalkan.');

            return self::SUCCESS;
        }

        DB::transaction(function () use ($periode) {

            // Nonaktifkan semua
            Periode::where('is_active', true)
                ->update([
                    'is_active' => false
                ]);

            // Aktifkan yang dipilih
            $periode->update([
                'is_active' => true
            ]);
        });

        $this->info(
            "Periode {$periode->periode} berhasil diaktifkan."
        );

        return self::SUCCESS;
    }
}
