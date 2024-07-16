<?php

namespace App\Imports;



use App\Models\Nis;
use App\Models\Siswa;
use App\Models\Statusanak;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class SiswaImport implements ToCollection
{
    public function collection(Collection $data)
    {
        $headers = $data[0]->toArray();

        function excelDateToDate($excelDate)
        {
            // Check if $excelDate is numeric and greater than 0
            if (!is_numeric($excelDate) || $excelDate <= 0) {
                return null; // Return null for invalid or empty Excel dates
            }

            return \Carbon\Carbon::createFromDate(1899, 12, 30)->addDays($excelDate - 1)->format('yyyy/mm/dd');
        }

        foreach ($data as $index => $rowData) {
            if ($index === 0) {
                // Skip the headers row
                continue;
            }

            $values = $rowData->toArray();
            $row = array_combine($headers, $values);

            // Validate and convert tanggal_lahir
            $tanggal_lahir = excelDateToDate($row['tanggal_lahir']);
            if ($tanggal_lahir === null) {
                // Handle error or skip this row if necessary
                continue;
            }

            // Check if Siswa already exists by id
            $existingSiswa = Siswa::where('id', $row['id'])->first();
            if ($existingSiswa) {
                // If Siswa exists, skip this row
                continue;
            }

            // Check if Siswa already exists by nama_siswa and tanggal_lahir in Nis table
            $existingNis = Nis::query()
                ->where('siswa_id', $existingSiswa)
                ->first();
            if ($existingNis) {
                // If nama_siswa and tanggal_lahir combination exists, skip this row
                continue;
            }

            // Create new Siswa
            $siswa = Siswa::create([
                'id' => $row['id'],
                'nama_siswa' => $row['nama_siswa'],
                'jenis_kelamin' => $row['jenis_kelamin'],
                'agama' => $row['agama'],
                'tempat_lahir' => $row['tempat_lahir'],
                'tanggal_lahir' => $tanggal_lahir,
                'kota_asal' => $row['kota_asal'],
                'created_at' => $row['created_at'],
                'updated_at' => $row['updated_at'],
            ]);

            // Save or update StatusAnak
            Statusanak::updateOrCreate(
                ['siswa_id' => $siswa->id],
                [
                    'status_anak' => $row['status_anak'],
                    'jumlah_saudara' => $row['jumlah_saudara'],
                    'anak_ke' => $row['anak_ke'],
                    'created_at' => $row['created_at'],
                    'updated_at' => $row['updated_at'],
                    'nama_ayah' => $row['nama_ayah'],
                    'pekerjaan_ayah' => $row['pekerjaan_ayah'],
                    'pekerjaan_ibu' => $row['pekerjaan_ibu'],
                    'nomor_hp_ayah' => $row['nomor_hp_ayah'],
                    'nama_ibu' => $row['nama_ibu'],
                    'nomor_hp_ibu' => $row['nomor_hp_ibu'],
                ]
            );

            // Save or update Nis
            Nis::updateOrCreate(
                ['siswa_id' => $siswa->id],
                [
                    'nis' => is_numeric($row['nis']),
                    'madrasah_diniyah' => $row['madrasah_diniyah'],
                    'nama_lembaga' => $row['nama_lembaga'],
                    'tanggal_masuk' => excelDateToDate($row['tanggal_masuk']),
                    'created_at' => $row['created_at'],
                    'updated_at' => $row['updated_at'],
                ]
            );
        }

        return response()->json(['message' => 'Data processed successfully']);
    }
}
