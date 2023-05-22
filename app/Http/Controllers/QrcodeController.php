<?php

namespace App\Http\Controllers;

use App\Models\Absensikelas;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrcodeController
{
    public function Scan()
    {
        return view('presensi.asrama.Qrsesiasrama');
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'sesikelas' => 'required',
            'pesertakelas_id' => 'required',
            'keterangan' => 'required'
        ]);

        try {
            // Membuat QR code dari data yang diberikan
            $qrCodeImage = $this->generateQRCode(json_encode($data));

            if ($qrCodeImage) {
                // Simpan QR code ke tempat yang sesuai, misalnya penyimpanan file atau database
                // Contoh penyimpanan file:
                $filename = 'qr_code_' . time() . '.png';
                $path = public_path('qr_codes/' . $filename);
                file_put_contents($path, $qrCodeImage);

                // Menyimpan data absensi kelas dan path QR code ke database
                $data['qr_code_path'] = $path;
                Absensikelas::create($data);

                return response()->json(['message' => 'Data absensi kelas berhasil disimpan'], 201);
            } else {
                return response()->json(['message' => 'Gagal membuat QR code'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan saat menyimpan data'], 500);
        }
    }

    public function generateQrCode()
    {
        $data = 'Contoh data QR code';

        $qrCode = QrCode::format('png')->size(200)->generate($data);


        return response($qrCode)->header('Content-Type', 'image/png');
    }
        
    
}
