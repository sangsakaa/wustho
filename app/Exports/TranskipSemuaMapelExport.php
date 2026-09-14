<?php

namespace App\Exports;

use App\Models\Daftar_lulusan;
use App\Models\Mapel;
use App\Models\Nilai_Transkip;
use App\Models\Transkip;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TranskipSemuaMapelExport implements
    FromCollection,
    WithHeadings,
    WithStyles,
    WithTitle
{
    protected $periodeId;
    protected $kelasmiId;

    public function __construct($periodeId, $kelasmiId)
    {
        $this->periodeId = $periodeId;
        $this->kelasmiId = $kelasmiId;
    }

    public function collection()
    {
        /*
        |--------------------------------------------------------------------------
        | PESERTA KELAS
        |--------------------------------------------------------------------------
        */

        $peserta = Daftar_lulusan::query()
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
                'siswa',
                'siswa.id',
                '=',
                'pesertakelas.siswa_id'
            )
            ->leftJoin(
                'nis',
                'nis.siswa_id',
                '=',
                'siswa.id'
            )
            ->where(
                'pesertakelas.kelasmi_id',
                $this->kelasmiId
            )
            ->select([
                'daftar_lulusan.id as daftar_lulusan_id',
                'daftar_lulusan.nomor_ijazah',
                'siswa.nama_siswa',
                'nis.nis',
                'kelasmi.id as kelasmi_id',
                'kelasmi.nama_kelas',
            ])
            ->orderBy('siswa.nama_siswa')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | SEMUA TRANSKIP UNTUK KELAS TERSEBUT
        |--------------------------------------------------------------------------
        */

        $transkips = Transkip::query()
            ->where('periode_id', $this->periodeId)
            ->where('kelasmi_id', $this->kelasmiId)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | MAPEL DARI TRANSKIP KELAS TERSEBUT
        |--------------------------------------------------------------------------
        */

        $mapelIds = $transkips
            ->pluck('mapel_id')
            ->unique()
            ->values();


        $mapels = Mapel::query()
            ->whereIn('id', $mapelIds)
            ->orderBy('mapel')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | SEMUA NILAI
        |--------------------------------------------------------------------------
        */

        $nilai = Nilai_Transkip::query()
            ->whereIn(
                'transkip_id',
                $transkips->pluck('id')
            )
            ->get()
            ->groupBy(function ($item) {
                return
                    $item->daftar_lulusan_id
                    . '-'
                    . $item->transkip_id;
            });


        /*
        |--------------------------------------------------------------------------
        | DATA EXCEL
        |--------------------------------------------------------------------------
        */

        return $peserta->map(function ($siswa, $index) use (
            $mapels,
            $transkips,
            $nilai
        ) {

            $row = [
                'No' => $index + 1,
                'NIS' => $siswa->nis ?? '-',
                'Nama Siswa' => $siswa->nama_siswa ?? '-',
                'Kelas' => $siswa->nama_kelas ?? '-',
            ];

            $total = 0;
            $jumlah = 0;


            /*
            |--------------------------------------------------------------------------
            | NILAI SETIAP MAPEL
            |--------------------------------------------------------------------------
            */

            foreach ($mapels as $mapel) {

                /*
                | Ambil transkip mapel untuk kelas ini
                */

                $transkipMapel = $transkips
                    ->where('mapel_id', $mapel->id)
                    ->first();

                $nilaiAkhir = 0;

                if ($transkipMapel) {

                    $key =
                        $siswa->daftar_lulusan_id
                        . '-'
                        . $transkipMapel->id;

                    $dataNilai = $nilai->get($key);

                    if ($dataNilai) {

                        $nilaiAkhir =
                            $dataNilai->first()->nilai_akhir ?? 0;
                    }
                }


                /*
                | Kolom mapel
                */

                $row[$mapel->mapel] = $nilaiAkhir;


                /*
                | Untuk rata-rata
                */

                if ($nilaiAkhir !== null && $nilaiAkhir > 0) {

                    $total += $nilaiAkhir;

                    $jumlah++;
                }
            }


            /*
            |--------------------------------------------------------------------------
            | RATA-RATA
            |--------------------------------------------------------------------------
            */

            $row['Rata-rata'] = $jumlah > 0
                ? round($total / $jumlah, 2)
                : 0;


            return $row;
        });
    }


    /*
    |--------------------------------------------------------------------------
    | HEADER
    |--------------------------------------------------------------------------
    */

    public function headings(): array
    {
        /*
        | Ambil transkip khusus kelas
        */

        $transkips = Transkip::query()
            ->where('periode_id', $this->periodeId)
            ->where('kelasmi_id', $this->kelasmiId)
            ->get();


        /*
        | Ambil mapel yang benar-benar digunakan kelas
        */

        $mapels = Mapel::query()
            ->whereIn(
                'id',
                $transkips
                    ->pluck('mapel_id')
                    ->unique()
            )
            ->orderBy('mapel')
            ->pluck('mapel')
            ->toArray();


        return array_merge(
            [
                'No',
                'NIS',
                'Nama Siswa',
                'Kelas',
            ],
            $mapels,
            [
                'Rata-rata',
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | NAMA SHEET
    |--------------------------------------------------------------------------
    */

    public function title(): string
    {
        return 'Transkip Kelas';
    }


    /*
    |--------------------------------------------------------------------------
    | STYLE
    |--------------------------------------------------------------------------
    */

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
