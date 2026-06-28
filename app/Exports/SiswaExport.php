<?php

namespace App\Exports;

use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class SiswaExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    public function collection()
    {
        return Siswa::query()
            ->leftJoin('nis', 'nis.siswa_id', '=', 'siswa.id')
            ->leftJoin('statusanak', 'statusanak.siswa_id', '=', 'siswa.id')
            ->leftJoin('statuspengamal', 'statuspengamal.siswa_id', '=', 'siswa.id')
            ->select(
                'siswa.*',
                'nis.nis',
                'nis.nama_lembaga',
                'nis.madrasah_diniyah',
                // 'nis.tanggal_masuk',
                // 'statuspengamal.status_pengamal',
                // 'statusanak.status_anak',
                // 'statusanak.anak_ke',
                // 'statusanak.jumlah_saudara',
                // 'statusanak.nama_ayah',
                // 'statusanak.nama_ibu',
                // 'statusanak.pekerjaan_ayah',
                // 'statusanak.pekerjaan_ibu',
                // 'statusanak.nomor_hp_ayah',
                // 'statusanak.nomor_hp_ibu'
            )
            ->orderBy('nis')
            ->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'NIS',
            'Nama',
            'Jenis Kelamin',
            'Agama',
            'Tempat Lahir',
            'Tanggal Lahir',
            // 'Kota Asal',
            'Lembaga',
            'Madrasah Diniyah',
            // 'Tanggal Masuk',
            // 'Status Pengamal',
            // 'Status Anak',
            // 'Anak Ke',
            // 'Jumlah Saudara',
            // 'Nama Ayah',
            // 'Nama Ibu',
            // 'Pekerjaan Ayah',
            // 'Pekerjaan Ibu',
            // 'HP Ayah',
            // 'HP Ibu',
        ];
    }

    public function map($row): array
    {
        static $no = 1;

        return [
            $no++,
            $row->nis,
            $row->nama_siswa,
            $row->jenis_kelamin,
            $row->agama,
            $row->tempat_lahir,
            $row->tanggal_lahir,
            // $row->kota_asal,
            $row->nama_lembaga,
            $row->madrasah_diniyah,
            // $row->tanggal_masuk,
            // $row->status_pengamal,
            // $row->status_anak,
            // $row->anak_ke,
            // $row->jumlah_saudara,
            // $row->nama_ayah,
            // $row->nama_ibu,
            // $row->pekerjaan_ayah,
            // $row->pekerjaan_ibu,
            // $row->nomor_hp_ayah,
            // $row->nomor_hp_ibu,
        ];
    }
}
