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

        $success = [];
        $errors = [];
        $skipped = [];

        function excelDateToDate($excelDate)
        {
            if (!is_numeric($excelDate) || $excelDate <= 0) {
                return null;
            }

            return \Carbon\Carbon::createFromDate(1899, 12, 30)
                ->addDays($excelDate)
                ->format('Y-m-d');
        }

        foreach ($data as $index => $rowData) {
            if ($index === 0) continue;

            try {
                $values = $rowData->toArray();
                $row = array_combine($headers, $values);

                // Validasi tanggal lahir
                $tanggal_lahir = excelDateToDate($row['tanggal_lahir']);
                if ($tanggal_lahir === null) {
                    $errors[] = "Baris ke-" . ($index + 1) . " : Tanggal lahir tidak valid";
                    continue;
                }

                // Cek duplikat
                $existingSiswa = Siswa::where('id', $row['id'])->first();
                if ($existingSiswa) {
                    $skipped[] = "Baris ke-" . ($index + 1) . " : ID {$row['id']} sudah ada";
                    continue;
                }

                // Insert siswa
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

                // Status anak
                Statusanak::updateOrCreate(
                    ['siswa_id' => $siswa->id],
                    [
                        'status_anak' => $row['status_anak'],
                        'jumlah_saudara' => $row['jumlah_saudara'],
                        'anak_ke' => $row['anak_ke'],
                        'nama_ayah' => $row['nama_ayah'],
                        'pekerjaan_ayah' => $row['pekerjaan_ayah'],
                        'pekerjaan_ibu' => $row['pekerjaan_ibu'],
                        'nomor_hp_ayah' => $row['nomor_hp_ayah'],
                        'nama_ibu' => $row['nama_ibu'],
                        'nomor_hp_ibu' => $row['nomor_hp_ibu'],
                        'created_at' => $row['created_at'],
                        'updated_at' => $row['updated_at'],
                    ]
                );

                // NIS
                Nis::updateOrCreate(
                    ['siswa_id' => $siswa->id],
                    [
                        'nis' => $row['nis'],
                        'madrasah_diniyah' => $row['madrasah_diniyah'],
                        'nama_lembaga' => $row['nama_lembaga'],
                        'tanggal_masuk' => excelDateToDate($row['tanggal_masuk']),
                        'created_at' => $row['created_at'],
                        'updated_at' => $row['updated_at'],
                    ]
                );

                $success[] = "Baris ke-" . ($index + 1) . " : {$row['nama_siswa']} berhasil diimport";
            } catch (\Exception $e) {
                $errors[] = "Baris ke-" . ($index + 1) . " : " . $e->getMessage();
            }
        }

        return redirect()->back()->with('import_result', [
            'summary' => [
                'total' => count($data) - 1,
                'success' => count($success),
                'skipped' => count($skipped),
                'errors' => count($errors),
            ],
            'detail' => [
                'success' => $success,
                'skipped' => $skipped,
                'errors' => $errors,
            ]
        ]);
    }
}
