<?php

namespace App\Exports;

use App\Models\Daftar_lulusan;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class DaftarLulusanExport implements
    FromQuery,
    WithHeadings,
    WithMapping,
    ShouldAutoSize
{
    protected $lulusanId;

    public function __construct($lulusanId)
    {
        $this->lulusanId = $lulusanId;
    }

    public function query()
    {
        return Daftar_lulusan::query()
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
            ->leftJoin(
                'daftar_nominasi',
                'daftar_nominasi.pesertakelas_id',
                '=',
                'pesertakelas.id'
            )
            ->leftJoin(
                'statusanak',
                'statusanak.siswa_id',
                '=',
                'siswa.id'
            )
            ->select([
                'daftar_lulusan.id',
                'daftar_lulusan.nomor_ijazah',
                'daftar_nominasi.nomor_ujian',
                'kelasmi.nama_kelas',
                'siswa.nama_siswa',
                'nis.nis',
                'statusanak.nama_ayah',
            ])
            ->where(
                'daftar_lulusan.lulusan_id',
                $this->lulusanId
            )
            ->orderBy('daftar_lulusan.nomor_ijazah')
            ->orderBy('siswa.nama_siswa');
    }

    public function headings(): array
    {
        return [
            'No',
            'Nomor Ijazah',
            'Nomor Ujian',
            'Kelas',
            'Nama Siswa',
            'NIS',
            'Nama Ayah',
        ];
    }

    public function map($row): array
    {
        static $no = 0;

        return [
            ++$no,
            $row->nomor_ijazah,
            $row->nomor_ujian,
            $row->nama_kelas,
            $row->nama_siswa,
            $row->nis,
            $row->nama_ayah,
        ];
    }
}
