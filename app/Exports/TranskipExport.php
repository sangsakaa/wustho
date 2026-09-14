<?php

namespace App\Exports;

use App\Models\Transkip;
use App\Models\Nilai_Transkip;
use App\Models\Daftar_lulusan;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TranskipExport implements FromCollection, WithHeadings, WithTitle, WithStyles
{
    protected $transkip;

    public function __construct(Transkip $transkip)
    {
        $this->transkip = $transkip;
    }

    public function collection()
    {
        $transkip = $this->transkip;

        $dataNilaiTranskip = Nilai_Transkip::query()
            ->where('transkip_id', $transkip->id);

        $data = Daftar_lulusan::query()
            ->leftJoin(
                'pesertakelas',
                'pesertakelas.id',
                '=',
                'daftar_lulusan.pesertakelas_id'
            )
            ->leftJoin(
                'kelasmi',
                'kelasmi.id',
                '=',
                'pesertakelas.kelasmi_id'
            )
            ->leftJoin(
                'lulusan',
                'lulusan.id',
                '=',
                'daftar_lulusan.lulusan_id'
            )
            ->leftJoin(
                'siswa',
                'siswa.id',
                '=',
                'pesertakelas.siswa_id'
            )
            ->leftJoin(
                'nis',
                'siswa.id',
                '=',
                'nis.siswa_id'
            )
            ->leftJoinSub(
                $dataNilaiTranskip,
                'data_nilai',
                function ($join) {
                    $join->on(
                        'data_nilai.daftar_lulusan_id',
                        '=',
                        'daftar_lulusan.id'
                    );
                }
            )
            ->where(
                'pesertakelas.kelasmi_id',
                $transkip->kelasmi_id
            )
            ->select([
                'daftar_lulusan.nomor_ijazah',
                'nis.nis',
                'siswa.nama_siswa',
                'kelasmi.nama_kelas',
                'data_nilai.nilai_akhir',
            ])
            ->orderBy('kelasmi.nama_kelas')
            ->orderBy('siswa.nama_siswa')
            ->get();

        return $data->values()->map(function ($item, $index) use ($transkip) {

            return [
                'No'             => $index + 1,
                'No. Ijazah'     => $item->nomor_ijazah ?? '-',
                'NIS'            => $item->nis ?? '-',
                'Nama Siswa'     => $item->nama_siswa ?? '-',
                'Kelas'          => $item->nama_kelas ?? '-',
                'Mata Pelajaran' => $transkip->mapel->mapel ?? '-',
                'Jenis Ujian'    => $transkip->jenisUjian->nama_ujian ?? '-',
                'Nilai'          => $item->nilai_akhir ?? 0,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No',
            'No. Ijazah',
            'NIS',
            'Nama Siswa',
            'Kelas',
            'Mata Pelajaran',
            'Jenis Ujian',
            'Nilai',
        ];
    }

    public function title(): string
    {
        return 'Transkip';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => [
                    'bold' => true,
                ],
            ],
        ];
    }
}
