<?php

namespace App\Exports;

use App\Models\Siswa;


use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;


class TemplateExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function headings(): array
    {
        return [
            // siswa
            'id',
            'nama_siswa',
            'jenis_kelamin',
            'agama',
            'tempat_lahir',
            'tanggal_lahir',
            'kota_asal',
            'created_at',
            'updated_at',
            // status anak
            'id',
            'siswa_id',
            'status_anak',
            'jumlah_saudara',
            'anak_ke',
            'created_at',
            'updated_at',
            'nama_ayah',
            'pekerjaan_ayah',
            'pekerjaan_ibu',
            'nomor_hp_ayah',
            'nama_ibu',
            'nomor_hp_ibu',
            // nis
            'id',
            'siswa_id',
            'nis',
            'madrasah_diniyah',
            'nama_lembaga',
            'tanggal_masuk',
            'created_at',
            'updated_at'
        ];
    }

    public function collection()
    {
        return Siswa::select([
            'siswa.id',
            'siswa.nama_siswa',
            'siswa.jenis_kelamin',
            'siswa.agama',
            'siswa.tempat_lahir',
            'siswa.tanggal_lahir',
            'siswa.kota_asal',
            'siswa.created_at',
            'siswa.updated_at',
            'statusanak.id as status_anak_id',
            'statusanak.siswa_id',
            'statusanak.status_anak',
            'statusanak.jumlah_saudara',
            'statusanak.anak_ke',
            'statusanak.created_at as status_anak_created_at',
            'statusanak.updated_at as status_anak_updated_at',
            'statusanak.nama_ayah',
            'statusanak.pekerjaan_ayah',
            'statusanak.pekerjaan_ibu',
            'statusanak.nomor_hp_ayah',
            'statusanak.nama_ibu',
            'statusanak.nomor_hp_ibu',
            'nis.id as nis_id',
            'nis.siswa_id as siswaIdNis',
            'nis.nis',
            'nis.madrasah_diniyah',
            'nis.nama_lembaga',
            'nis.tanggal_masuk',
            'nis.created_at',
            'nis.updated_at'
        ])
            ->leftJoin('statusanak', 'siswa.id', '=', 'statusanak.siswa_id')
            ->leftJoin('nis', 'siswa.id', '=', 'nis.siswa_id')
            ->where('siswa.id', 9) // Change this to filter by specific ID if needed
            ->get();
    }
}
