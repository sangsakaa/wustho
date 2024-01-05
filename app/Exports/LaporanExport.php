<?php

namespace App\Exports;


use App\Models\Sesikelas;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Carbon\Carbon;

class LaporanExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function headings(): array
    {
        // Tambahkan header tambahan sesuai kebutuhan
        return [
            'nama_siswa',
            'nama_kelas',
            'nama_asrama',
            'periode',
            'ket_semester',
            'tanggal_update',
            'jumlah_hadir',
            'jumlah_izin',
            'jumlah_sakit',
            'jumlah_alfa',
            // Tambahkan header lainnya jika diperlukan
        ];
    }

    public function collection()
    {  
        return
            Sesikelas::query()
            ->join('kelasmi', 'kelasmi.id', 'sesikelas.kelasmi_id')
            ->join('absensikelas', 'absensikelas.sesikelas_id', 'sesikelas.id')
            ->join('pesertakelas', 'pesertakelas.id', 'absensikelas.pesertakelas_id')
            ->join('siswa', 'siswa.id', 'pesertakelas.siswa_id')
            ->join('pesertaasrama', 'pesertaasrama.siswa_id', 'siswa.id')
            ->join('asramasiswa', 'asramasiswa.id', 'pesertaasrama.asramasiswa_id')
            ->join('asrama', 'asrama.id', 'asramasiswa.asrama_id')
            ->where('kelasmi.periode_id', session('periode_id'))
            ->where('asramasiswa.periode_id', session('periode_id'))
            ->select(
                'nama_siswa',
                'nama_kelas',
                'nama_asrama',
            // 'periode',
            // 'ket_semester',
            DB::raw('MAX(tgl) AS tgl'), // Menggunakan MAX untuk tgl
                DB::raw('SUM(CASE WHEN absensikelas.keterangan = "hadir" THEN 1 ELSE 0 END) AS jumlah_hadir'),
            DB::raw('SUM(CASE WHEN absensikelas.keterangan = "izin" THEN 1 ELSE 0 END) AS jumlah_izin'),
            DB::raw('SUM(CASE WHEN absensikelas.keterangan = "alfa" THEN 1 ELSE 0 END) AS jumlah_alfa'),
                DB::raw('SUM(CASE WHEN absensikelas.keterangan = "sakit" THEN 1 ELSE 0 END) AS jumlah_sakit')
            )
        ->groupBy('nama_siswa', 'nama_kelas', 'nama_asrama')
        ->orderBy('nama_kelas')
        ->orderBy('nama_siswa')
        ->whereMonth('tgl', now()->month)
            ->get([
                // 'nama_siswa',
                // 'nama_kelas',
                // 'nama_asrama',
                // DB::raw('jumlah_hadir AS Jumlah Hadir'),
                // DB::raw('jumlah_izin AS Jumlah Izin'),
                // DB::raw('jumlah_alfa AS Jumlah Alfa'),
                // DB::raw('jumlah_sakit AS Jumlah Sakit')
            ]);

    }
}
