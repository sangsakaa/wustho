<?php

use App\Models\Mapel;
use App\Models\Siswa;
use App\Models\Kelasmi;
use App\Models\Absensikelas;
use App\Models\Pesertaasrama;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\AsramaController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\LulusanCotroller;
use App\Http\Controllers\QrcodeController;
use App\Http\Controllers\RaportController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\KelasmiController;
use App\Http\Controllers\PararelController;
use App\Http\Controllers\SeleksiController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\TranskipController;
use App\Http\Controllers\UserguruController;
use App\Http\Controllers\ValidasiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PerangkatController;
use App\Http\Controllers\SesikelasController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\RekapAsamaController;
use App\Http\Controllers\SesiasramaController;
use App\Http\Controllers\AsramasiswaController;
use App\Http\Controllers\PelanggaranController;
use App\Http\Controllers\AbsensikelasController;
use App\Http\Controllers\PresensiGuruController;
use App\Http\Controllers\PresensikelasController;
use App\Http\Controllers\SesiPerangkatController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// batas
Route::get('/manajemen-user', [RegisteredUserController::class, 'index'])->middleware(['auth'])->name('admin');
Route::get('/userdashboard', [UserController::class, 'DashboardUser'])->middleware(['auth'])->name('userdashboard');


// UserGuru Controller
Route::get('/nilaiperguru', [UserguruController::class, 'UserGuru'])->middleware(['auth'])->name('nilaiperguru');
Route::get('/gurudashboard', [UserguruController::class, 'DashboardGuru'])->middleware(['auth'])->name('gurudashboard');

Route::get('manajemen', [RegisteredUserController::class, 'manajemen'])->middleware(['auth'])->name('manajemen');
Route::get('register', [RegisteredUserController::class, 'create'])->middleware(['auth'])->name('register');

Route::get('HasRole', [RegisteredUserController::class, 'HasRole'])->middleware(['auth'])->name('HasRole');
Route::post('HasRole', [RegisteredUserController::class, 'storeole']);
Route::post('HasRole', [RegisteredUserController::class, 'storeHasRole']);

Route::post('admin', [RegisteredUserController::class, 'role_has_permission'])->middleware(['auth']);
Route::delete('admin/{user}', [RegisteredUserController::class, 'destroy']);
Route::get('/buatakunsiswa', [RegisteredUserController::class, 'buatAkunSiswa'])->middleware(['auth']);
Route::get('/buatakunguru', [RegisteredUserController::class, 'buatAkunGuru'])->middleware(['auth']);
// User
Route::get('/user', [UserController::class, 'Personal'])->middleware(['auth'])->name('user');
Route::get('/riwayatkelas', [UserController::class, 'Riwayatkelas'])->middleware(['auth'])->name('riwayatkelas');
Route::get('/riwayatkehadiran', [UserController::class, 'Riwayatkehadiran'])->middleware(['auth'])->name('riwayatkehadiran');
// role
Route::get('dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('siswa', [SiswaController::class, 'index'])->middleware(['auth',])->name('siswa');
Route::get('siswa/{siswa}', [SiswaController::class, 'show']);
Route::get('biodata/{siswa}', [SiswaController::class, 'biodata']);
Route::get('transkip/{siswa}', [SiswaController::class, 'transkip']);
Route::get('nis/{siswa}', [SiswaController::class, 'nis']);
Route::get('nis/{nis}/edit', [SiswaController::class, 'editNis']);
Route::patch('nis/{nis}', [SiswaController::class, 'UpdateNis']);
Route::get('statuspengamal/{siswa}', [SiswaController::class, 'statuspengamal']);

Route::post('statuspengamal/{siswa}', [SiswaController::class, 'storeSP']);

Route::post('statusanak/{siswa}', [SiswaController::class, 'storeSA']);
Route::delete('statusanak/{statusanak}', [SiswaController::class, 'HapusStatusAnaka']);
Route::delete('statuspengamal/{siswa}', [SiswaController::class, 'destroySP']);
Route::get('statusanak/{siswa}', [SiswaController::class, 'statusanak']);
Route::get('addsiswa', [SiswaController::class, 'create'])->middleware(['auth']);
Route::post('siswa', [SiswaController::class, 'store']);
Route::post('nis/{siswa}', [SiswaController::class, 'storeNis']);
Route::delete('siswa/{siswa}', [SiswaController::class, 'destroy']);
Route::delete('nis/{nis}', [SiswaController::class, 'destroyNis']);
Route::get('siswa/{siswa}/edit', [SiswaController::class, 'edit']);
Route::patch('siswa/{siswa}', [SiswaController::class, 'update']);
Route::get('kelas', [KelasController::class, 'index'])->middleware(['auth'])->name('kelas');
Route::get('addkelas', [KelasController::class, 'create'])->middleware(['auth'])->name('addkelas');
Route::get('kelas/{kelas}/edit', [KelasController::class, 'edit'])->middleware(['auth']);
Route::post('kelas', [KelasController::class, 'store'])->middleware(['auth'])->name('kelas');
Route::delete('kelas/{kelas}', [KelasController::class, 'destroy'])->middleware(['auth']);
Route::post('pesertakolektif', [KelasController::class, 'StoreKolektif'])->middleware(['auth'])->name('pesertakolektif');
Route::get('pesertakolektif/{kelasmi}', [KelasController::class, 'pesertakolektif'])->middleware(['auth']);

// CONTROLLER KELAS MI
Route::get('kelas_mi', [KelasmiController::class, 'index'])->middleware(['auth'])->name('kelas_mi');
Route::get('addkelas_mi', [KelasmiController::class, 'create'])->middleware(['auth'])->name('addkelas_mi');
Route::post('kelas_mi', [KelasmiController::class, 'store'])->middleware(['auth'])->name('kelas_mi');
Route::get('kelas_mi/{kelasmi}/edit', [KelasmiController::class, 'edit'])->middleware(['auth']);
Route::delete('kelas_mi/{kelasmi}', [KelasmiController::class, 'destroy'])->middleware(['auth']);
Route::patch('kelas_mi/{kelasmi}', [KelasmiController::class, 'update'])->middleware(['auth']);
// peseta kelas
Route::get('pesertakelas/{kelasmi}', [KelasmiController::class, 'show'])->middleware(['auth'])->name('pesertakelas');
Route::delete('pesertakelas/{pesertakelas}', [KelasmiController::class, 'hapus'])->middleware(['auth'])->name('pesertakelas');
Route::get('pesertakelas/{pesertakelas}/edit', [KelasmiController::class, 'editpesertakelas']);
Route::patch('pesertakelas/{pesertakelas}', [KelasmiController::class, 'storepesertakelas']);
// Controller nilai
Route::get('nilaimapel', [NilaiController::class, 'index'])->middleware(['auth'])->name('nilaimapel');
Route::get('nilai/{nilaimapel}', [NilaiController::class, 'show'])->middleware(['auth']);
Route::post('nilai', [NilaiController::class, 'store'])->middleware(['auth'])->name('nilai');
Route::get('nilai', [NilaiController::class, 'nilaipersiswa'])->middleware(['auth'])->name('nilaipersiswa');
Route::post('nilaimapel', [NilaiController::class, 'storeNilaimapel'])->middleware(['auth'])->name('nilaimapel');
Route::delete('nilaimapel/{nilaimapel}', [NilaiController::class, 'destroy'])->middleware(['auth']);
// Controller Asrama
Route::get('asrama', [AsramaController::class, 'index'])->middleware(['auth'])->name('asrama');
Route::post('asrama', [AsramaController::class, 'store'])->middleware(['auth'])->name('asrama');
Route::delete('asrama/{asrama}', [AsramaController::class, 'destroy'])->middleware(['auth']);
Route::get('addasrama', [AsramaController::class, 'create'])->middleware(['auth'])->name('addasrama');
// Controller Asrama Siswa
Route::get('asramasiswa', [AsramasiswaController::class, 'index'])->middleware(['auth'])->name('asramasiswa');
Route::post('asramasiswa', [AsramasiswaController::class, 'store'])->middleware(['auth']);
Route::patch('asramasiswa/{asramasiswa}', [AsramasiswaController::class, 'update']);
Route::get('asramasiswa/{asramasiswa}/edit', [AsramasiswaController::class, 'edit'])->middleware(['auth']);
Route::get('addasramasiswa', [AsramasiswaController::class, 'create'])->middleware(['auth']);
Route::get('pesertaasrama/{asramasiswa}', [AsramasiswaController::class, 'show'])->middleware(['auth']);
Route::delete('asramasiswa/{asramasiswa}', [AsramasiswaController::class, 'destroy'])->middleware(['auth']);
Route::delete('pesertaasrama/{pesertaasrama}', [AsramasiswaController::class, 'PesertaAsrama'])->middleware(['auth']);
Route::get('pesertaasrama/{pesertaasrama}/edit', [AsramasiswaController::class, 'editpeserta'])->middleware(['auth']);
Route::get('kolektifasrama/{asramasiswa}', [AsramasiswaController::class, 'kolelktifasrama'])->middleware(['auth']);
Route::post('kolektifasrama', [AsramasiswaController::class, 'StoreKolektifasrama'])->middleware(['auth']);
Route::patch('pesertaasrama/pesertaasrama/{asramasiswa}', [AsramasiswaController::class, 'updatepeserta']);
// Controller Guru
Route::get('guru', [GuruController::class, 'index'])->middleware(['auth'])->name('guru');
Route::get('guru/{guru}', [GuruController::class, 'show'])->middleware(['auth']);
Route::get('addGuru', [GuruController::class, 'create'])->middleware(['auth']);
Route::post('guru', [GuruController::class, 'store'])->middleware(['auth']);
Route::delete('guru/{guru}', [GuruController::class, 'destroy'])->middleware(['auth']);
Route::patch('guru/{guru}', [GuruController::class, 'update'])->middleware(['auth']);
Route::get('guru/{guru}/edit', [GuruController::class, 'edit'])->middleware(['auth']);
// Nomor Induk Guru
Route::get('nig/{guru}', [GuruController::class, 'NIS'])->middleware(['auth'])->name('nis');
Route::post('nig/{guru}', [GuruController::class, 'nisGuru'])->middleware(['auth']);
Route::delete('nig/{nig}', [GuruController::class, 'destroyNig'])->middleware(['auth']);

// sesi Presensi Guru
Route::get('sesi-presensi-guru', [PresensiGuruController::class, 'index'])->middleware(['auth'])->name('sesi-presensi-guru');
Route::post('sesi-presensi-guru', [PresensiGuruController::class, 'store'])->middleware(['auth']);
Route::get('sesi-presensi-guru/{sesi_Kelas_Guru}', [PresensiGuruController::class, 'DaftarGuru'])->where('sesi_Kelas_Guru', '[0-9]+')->middleware(['auth']);
Route::post('sesi-presensi-guru/{sesi_Kelas_Guru}', [PresensiGuruController::class, 'AbsenGuru'])->middleware(['auth']);
Route::get('laporan-harian-guru', [PresensiGuruController::class, 'LaporanHarian'])->middleware(['auth'])->name('laporan-harian-guru');
Route::get('laporan-semester-guru', [PresensiGuruController::class, 'laporanSemester'])->middleware(['auth'])->name('laporan-semester-guru');
Route::delete('sesi-presensi-guru/{sesi_Kelas_Guru}', [PresensiGuruController::class, 'DeleteSesi'])->middleware(['auth']);
Route::get('sesi-presensi-guru/rekap', [PresensiGuruController::class, 'rekapSesi'])->middleware(['auth']);








// Controller Raport
Route::get('report/{pesertakelas}', [RaportController::class, 'show'])->middleware(['auth'])->name('report');
Route::get('raportkelas', [RaportController::class, 'raportkelas'])->middleware(['auth']);
Route::post('raportkelas', [RaportController::class, 'raportkelas'])->middleware(['auth']);
Route::get('peringkat', [RaportController::class, 'peringkat'])->middleware(['auth']);
Route::post('peringkat', [RaportController::class, 'peringkat'])->middleware(['auth']);

// Controller Mata Pelajaran
Route::get('mapel', [MapelController::class, 'index'])->middleware(['auth'])->name('mapel');
Route::get('edit-mapel/{mapel}', [MapelController::class, 'edit'])->middleware(['auth']);
Route::get('addmapel', [MapelController::class, 'create'])->middleware(['auth']);
Route::post('mapel', [MapelController::class, 'store'])->middleware(['auth']);
Route::patch('mapel/{mapel}', [MapelController::class, 'update']);
Route::delete('mapel/{mapel}', [MapelController::class, 'destroy'])->middleware(['auth']);

// Controller Pengaturan
Route::get('pengaturan', [PengaturanController::class, 'pengaturan'])->middleware(['auth'])->name('pengaturan');
Route::get('semester', [PengaturanController::class, 'semester'])->middleware(['auth'])->name('semester');
Route::get('cardlogin', [PengaturanController::class, 'cardlogin'])->middleware(['auth'])->name('cardlogin');
Route::get('periode', [PengaturanController::class, 'periode'])->middleware(['auth'])->name('periode');
Route::post('periode', [PengaturanController::class, 'storeperiode'])->middleware(['auth']);
Route::delete('periode/{periode}', [PengaturanController::class, 'deleteperiode'])->middleware(['auth']);
Route::get('sap', [PengaturanController::class, 'sap'])->middleware(['auth'])->name('sap');

// Ploting Kelas
Route::get('plotingkelas', [PengaturanController::class, 'plotingkelas'])->middleware(['auth']);
Route::get('ploting-kelas-jenis-kelamin', [PengaturanController::class, 'plotingJk'])->middleware(['auth']);


// Controller Sesi Asrama

Route::get('sesiasrama', [SesiasramaController::class, 'index'])->middleware(['auth'])->name('sesiasrama');
Route::get('sesiasrama/{sesiasrama}', [SesiasramaController::class, 'show'])->middleware(['auth']);
Route::post('sesiasrama', [SesiasramaController::class, 'store'])->middleware(['auth']);
Route::post('sesiasrama/presensi', [SesiasramaController::class, 'simpanpresensi'])->middleware(['auth']);
Route::delete('sesiasrama/{sesiasrama}', [SesiasramaController::class, 'destroy'])->middleware(['auth']);


// Controller Kegiatan
Route::get('kegiatan', [KegiatanController::class, 'index'])->middleware(['auth'])->name('kegiatan');
Route::get('kegiatan/{kegiatan}/edit', [KegiatanController::class, 'edit'])->middleware(['auth']);
Route::post('kegiatan', [KegiatanController::class, 'store'])->middleware(['auth']);
Route::get('addkegiatan', [KegiatanController::class, 'create'])->middleware(['auth']);
Route::delete('kegiatan/{kegiatan}', [KegiatanController::class, 'destroy'])->middleware(['auth']);
Route::patch('kegiatan/{kegiatan}', [KegiatanController::class, 'update']);


// List Pelanggaran
Route::get('addpelanggaran', [PelanggaranController::class, 'create'])->middleware(['auth']);
Route::post('addpelanggaran', [PelanggaranController::class, 'store'])->middleware(['auth']);
Route::delete('addpelanggaran/{pelanggaran}', [PelanggaranController::class, 'destroy'])->middleware(['auth']);

// Controller Presensikelas
Route::get('presensikelas', [PresensikelasController::class, 'index'])->middleware(['auth']);
Route::get('presensikelas/{kelasmi}', [PresensikelasController::class, 'show'])->middleware(['auth']);
Route::post('presensikelas', [PresensikelasController::class, 'store'])->middleware(['auth']);

// Controller AuthenticatedSession
Route::post('setperiode', [AuthenticatedSessionController::class, 'setPeriode'])->middleware(['auth'])->name('setperiode');

// Controller Sesikelas
Route::get('sesikelas', [SesikelasController::class, 'index'])->middleware(['auth'])->name('sesikelas');
Route::post('sesikelas', [SesikelasController::class, 'store'])->middleware(['auth']);
Route::delete('sesikelas/{sesikelas}', [SesikelasController::class, 'destroy'])->where('sesikelas', '[0-9]+')->middleware(['auth']);
Route::get('sesikelas/rekap', [SesikelasController::class, 'rekapSesi'])->middleware(['auth']);

// Controller Absensikelas
Route::get('absensikelas/{sesikelas}', [AbsensikelasController::class, 'index'])->where('sesikelas', '[0-9]+')->middleware(['auth']);
Route::post('absensikelas', [AbsensikelasController::class, 'store'])->middleware(['auth']);
Route::get('absensikelas/blanko', [AbsensikelasController::class, 'blanko'])->middleware(['auth'])->name('absensikelas/blanko');

Route::get('blankoHarian', [AbsensikelasController::class, 'blankoLApHarian'])->middleware(['auth'])->name('blankoHarian');
Route::get('absensikelas/rekap-per-hari', [AbsensikelasController::class, 'rekapPerHari'])->middleware(['auth'])->name('absensikelas/rekap-per-hari');
Route::get('absensikelas/rekap-per-bulan', [AbsensikelasController::class, 'rekapPerBulan'])->middleware(['auth'])->name('absensikelas/rekap-per-bulan');
Route::get('absensikelas/rekap-semester', [AbsensikelasController::class, 'rekapSemester'])->middleware(['auth'])->name('absensikelas/rekap-semester');

Route::get('rekap-harian', [RekapAsamaController::class, 'RekapHarian']);

Route::get('download_file', [PengaturanController::class, 'download_file']);
Route::patch('pesertaasrama/{pesertaasrama}', [AsramasiswaController::class, 'updatepeserta']);


// Data Validasi
Route::get('validasi-data', [ValidasiController::class, 'index'])->middleware(['auth']);
Route::get('blangko-ijazah/{lulusan}', [ValidasiController::class, 'blangkoijazah'])->middleware(['auth']);
Route::get('blangko-transkip/{lulusan}', [ValidasiController::class, 'blangkoTranskip'])->middleware(['auth']);


// LULUSAN
// CONTROLLER LULUSAN
Route::get('lulusan', [LulusanCotroller::class, 'index'])->middleware(['auth'])->name('lulusan');
Route::post('lulusan', [LulusanCotroller::class, 'store'])->middleware(['auth'])->name('lulusan');
Route::get('daftar-lulusan/{lulusan}', [LulusanCotroller::class, 'daftarLulusan'])->middleware(['auth']);
Route::get('kolektif-lulusan/{lulusan}', [LulusanCotroller::class, 'kolektifLulusan'])->middleware(['auth']);
Route::post('kolektif-lulusan/{lulusan}', [LulusanCotroller::class, 'storeLulusan'])->middleware(['auth']);
Route::delete('daftar-lulusan/{daftar_lulusan}', [LulusanCotroller::class, 'DeletePeserta'])->middleware(['auth']);
Route::delete('lulusan/{lulusan}', [LulusanCotroller::class, 'Destroy'])->middleware(['auth']);
Route::get('reservasi-ijazah/{daftar_lulusan}', [LulusanCotroller::class, 'edit'])->middleware(['auth']);
Route::patch('daftar-lulusan/{daftar_lulusan}', [LulusanCotroller::class, 'update'])->middleware(['auth']);


// LULUSAN
// CONTROLLER Transkip
Route::get('daftar-transkip', [TranskipController::class, 'index'])->middleware(['auth'])->name('daftar-transkip');
Route::post('daftar-transkip', [TranskipController::class, 'store'])->middleware(['auth'])->name('daftar-transkip');
Route::get('nilai_transkip/{transkip}', [TranskipController::class, 'daftarTranskip'])->middleware(['auth'])->name('nilai_transkip');
Route::post('nilai_transkip/{transkip}', [TranskipController::class, 'NilaiTranskip'])->middleware(['auth'])->name('nilai_transkip');
Route::delete('daftar-transkip/{transkip}', [TranskipController::class, 'DeleteTraskip'])->middleware(['auth']);

// Seleksi Controller

Route::get('daftar-seleksi', [SeleksiController::class, 'index'])->middleware(['auth'])->name('daftar-seleksi');
Route::post('daftar-seleksi', [SeleksiController::class, 'store'])->middleware(['auth'])->name('daftar-seleksi');
Route::get('daftar-nominasi/{nominasi}', [SeleksiController::class, 'daftarNominasi'])->middleware(['auth'])->name('daftar-nominasi');
Route::get('kolektif-daftar-nominasi/{nominasi}', [SeleksiController::class, 'daftarNominasiKelektif'])->middleware(['auth']);
Route::post('daftar-nominasi/{nominasi}', [SeleksiController::class, 'StoreNominasi'])->middleware(['auth'])->name('daftar-nominasi');
Route::delete('daftar-seleksi/{nominasi}', [SeleksiController::class, 'destroy']);
Route::delete('daftar-nominasi/{daftar_Nominasi}', [SeleksiController::class, 'destroyNominasi']);




// Controller Pararel
// 3
Route::get('juara-pararel', [PararelController::class, 'index'])->middleware(['auth']);
// 1
Route::get('Rekapitulasi-Nilai', [PararelController::class, 'indexSiswa'])->middleware(['auth']);
// 2
Route::get('Rekapitulasi-Nilai-Siswa', [PararelController::class, 'RekapNilaiSiswa'])->middleware(['auth']);


// Laporan Siswa Kelas
Route::get('Laporan-Kehadiran', [ReportController::class, 'LapKehadiran'])->middleware(['auth'])->name('Laporan-Kehadiran');

// Perangkat
Route::get('data-perangkat', [PerangkatController::class, 'index'])->middleware(['auth'])->name('data-perangkat');
Route::get('form-perangkat', [PerangkatController::class, 'create'])->middleware(['auth'])->name('form-perangkat');

Route::get('edit-form-perangkat/{perangkat}/edit', [PerangkatController::class, 'edit'])->middleware(['auth']);
Route::patch('edit-form-perangkat/{perangkat}/edit', [PerangkatController::class, 'update'])->middleware(['auth']);

Route::post('data-perangkat', [PerangkatController::class, 'store'])->middleware(['auth'])->name('form-perangkat');
// sesiPerangkat
Route::get('sesi-perangkat', [SesiPerangkatController::class, 'sesiPerangkat'])->name('sesi-perangkat');
Route::post('sesi-perangkat', [SesiPerangkatController::class, 'buatSesi']);
Route::get('/daftar-sesi-perangkat/{sesiPerangkat}', [SesiPerangkatController::class, 'daftarSesi']);
Route::post('/daftar-sesi-perangkat/{sesiPerangkat}', [SesiPerangkatController::class, 'StoredaftarSesi']);

Route::get('laporan-harian-perangkat', [SesiPerangkatController::class, 'LaporanHarian']);
Route::get('laporan-Bulanan-perangkat', [SesiPerangkatController::class, 'LaporanBulanan']);




// Jadwal Pelajaran

Route::get('Daftar-Jadwal', [JadwalController::class, 'Jadwal'])->middleware(['auth'])->name('Daftar-Jadwal');
Route::post('Daftar-Jadwal', [JadwalController::class, 'StoreJadwal'])->middleware(['auth']);
Route::get('jadwal-guru/{jadwal}', [JadwalController::class, 'DaftarJadwal'])->middleware(['auth']);
Route::post('jadwal-guru/{jadwal}', [JadwalController::class, 'StoreDaftarJadwal'])->middleware(['auth']);
Route::get('/cetak-jadwal-kolektif', [JadwalController::class, 'JadwalKolektif'])->name('cetak-jadwal-kolektif');
Route::get('cetak-jadwal-1', [JadwalController::class, 'CetakJadwal1'])->middleware(['auth']);
Route::get('cetak-jadwal-2', [JadwalController::class, 'CetakJadwal2'])->middleware(['auth']);
Route::get('cetak-jadwal-3', [JadwalController::class, 'CetakJadwal3'])->middleware(['auth']);
Route::get('laporan-poling-guru', [JadwalController::class, 'LaporanPloting'])->middleware(['auth']);
Route::get('laporan-poling-guru-kelas', [JadwalController::class, 'LaporanPlotingKelas'])->middleware(['auth']);

Route::delete('jadwal-guru/{daftar_Jadwal}', [JadwalController::class, 'destroyGuru'])->middleware(['auth']);
Route::delete('Daftar-Jadwal/{jadwal}', [JadwalController::class, 'destroy'])->middleware(['auth']);



// qrCode

Route::get('Qr-Scan', [QrcodeController::class, 'Scan'])->middleware(['auth'])->name('Qr-Scan');
Route::get('generate-Scan', [QrcodeController::class, 'generateQRCode'])->middleware(['auth'])->name('generate-Scan');




























Route::get(
    '/',
    function () {

        $kelasmi = Kelasmi::query()
            ->join('periode', 'periode.id', '=', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->select('kelasmi.nama_kelas', 'periode.periode', 'semester.ket_semester', 'periode.id')
            ->latest('kelasmi.created_at')
            ->first();
        // dd($kelasmi->id);
        $data = Absensikelas::query()
            ->join('sesikelas', 'sesikelas.id', '=', 'absensikelas.sesikelas_id')
            ->join('pesertakelas', 'pesertakelas.id', '=', 'absensikelas.pesertakelas_id')
            ->join('siswa', 'siswa.id', '=', 'pesertakelas.siswa_id')
            ->join('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
            // Ambil periode terakhir dari session
            ->whereIn('absensikelas.keterangan', ['alfa', 'sakit'])
            ->groupBy('nama_kelas', 'nama_siswa', 'periode_id')
            ->select(
                'nama_kelas',
                'nama_siswa',
                'periode_id',
                DB::raw('SUM(CASE WHEN absensikelas.keterangan = "alfa" THEN 1 ELSE 0 END) as total_alfa'),
                DB::raw('SUM(CASE WHEN absensikelas.keterangan = "sakit" THEN 1 ELSE 0 END) as total_sakit'),
                DB::raw('count(pesertakelas.id) as total_data')
            )
            ->orderBy('nama_kelas')
            ->orderBy('nama_siswa')
            ->where('kelasmi.periode_id', $kelasmi->id)
        ->get();
        $dataNIS = Siswa::query()
            ->leftjoin('nis', 'nis.siswa_id', 'siswa.id')
        ->join('pesertakelas', 'siswa.id', '=', 'pesertakelas.siswa_id')
        ->select('siswa.id', 'nis', 'nama_siswa', 'tempat_lahir', 'tanggal_lahir')
        ->distinct()
            // ->get()
        ;

    
        if (request('cari') !== null) {
            $dataNIS->where('nis', '=', request('cari'));
        }

        return view('welcome', [
            'data' => $data,
            'kelasmi',
            'dataNIS' => $dataNIS->get()
        ]);
    }
);




Route::get('/buttons/text', function () {
    return view('buttons-showcase.text');
})->middleware(['auth'])->name('buttons.text');

Route::get('/buttons/icon', function () {
    return view('buttons-showcase.icon');
})->middleware(['auth'])->name('buttons.icon');

Route::get('/buttons/text-icon', function () {
    return view('buttons-showcase.text-icon');
})->middleware(['auth'])->name('buttons.text-icon');

require __DIR__ . '/auth.php';
