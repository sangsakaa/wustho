<?php

use App\Http\Controllers\AbsensikelasController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\AsramaController;
use App\Http\Controllers\RaportController;
use App\Http\Controllers\KelasmiController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\SesiasramaController;
use App\Http\Controllers\AsramasiswaController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\PelanggaranController;
use App\Http\Controllers\PresensikelasController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\LulusanCotroller;
use App\Http\Controllers\RekapAsamaController;
use App\Http\Controllers\SesikelasController;
use App\Http\Controllers\TranskipController;
use App\Http\Controllers\UserguruController;
use App\Http\Controllers\ValidasiController;

// batas
Route::get('/manajemen-user', [RegisteredUserController::class, 'index'])->middleware(['auth'])->name('admin');
Route::get('/userdashboard', [UserController::class, 'DashboardUser'])->middleware(['auth'])->name('userdashboard');


// UserGuru Controller
Route::get('/nilaiperguru', [UserguruController::class, 'UserGuru'])->middleware(['auth'])->name('nilaiperguru');
Route::get('/gurudashboard', [UserguruController::class, 'DashboardGuru'])->middleware(['auth'])->name('gurudashboard');

Route::get('manajemen', [RegisteredUserController::class, 'manajemen'])->middleware(['auth'])->name('manajemen');
Route::get('register', [RegisteredUserController::class, 'create'])->middleware(['auth'])->name('register');
Route::get('HasRole', [RegisteredUserController::class, 'HasRole'])->middleware(['auth'])->name('HasRole');
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
Route::get('/', function () {
    return view('welcome');
});
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

// Controller Raport
Route::get('report/{pesertakelas}', [RaportController::class, 'show'])->middleware(['auth'])->name('report');
Route::get('raportkelas', [RaportController::class, 'raportkelas'])->middleware(['auth']);
Route::post('raportkelas', [RaportController::class, 'raportkelas'])->middleware(['auth']);
Route::get('peringkat', [RaportController::class, 'peringkat'])->middleware(['auth']);
Route::post('peringkat', [RaportController::class, 'peringkat'])->middleware(['auth']);

// Controller Mata Pelajaran
Route::get('mapel', [MapelController::class, 'index'])->middleware(['auth'])->name('mapel');
Route::get('addmapel', [MapelController::class, 'create'])->middleware(['auth']);
Route::post('mapel', [MapelController::class, 'store'])->middleware(['auth']);
Route::delete('mapel/{mapel}', [MapelController::class, 'destroy'])->middleware(['auth']);

// Controller Pengaturan
Route::get('pengaturan', [PengaturanController::class, 'pengaturan'])->middleware(['auth'])->name('pengaturan');
Route::get('semester', [PengaturanController::class, 'semester'])->middleware(['auth'])->name('semester');
Route::get('cardlogin', [PengaturanController::class, 'cardlogin'])->middleware(['auth'])->name('cardlogin');
Route::get('periode', [PengaturanController::class, 'periode'])->middleware(['auth'])->name('periode');
Route::post('periode', [PengaturanController::class, 'storeperiode'])->middleware(['auth']);
Route::delete('periode/{periode}', [PengaturanController::class, 'deleteperiode'])->middleware(['auth']);
Route::get('sap', [PengaturanController::class, 'sap'])->middleware(['auth'])->name('sap');
Route::get('plotingkelas', [PengaturanController::class, 'plotingkelas'])->middleware(['auth']);

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
Route::get('absensikelas/rekap-per-hari', [AbsensikelasController::class, 'rekapPerHari'])->middleware(['auth'])->name('absensikelas/rekap-per-hari');
Route::get('absensikelas/rekap-per-bulan', [AbsensikelasController::class, 'rekapPerBulan'])->middleware(['auth'])->name('absensikelas/rekap-per-bulan');
Route::get('absensikelas/rekap-semester', [AbsensikelasController::class, 'rekapSemester'])->middleware(['auth'])->name('absensikelas/rekap-semester');

Route::get('rekap-harian', [RekapAsamaController::class, 'RekapHarian']);

Route::get('download_file', [PengaturanController::class, 'download_file']);
Route::patch('pesertaasrama/{pesertaasrama}', [AsramasiswaController::class, 'updatepeserta']);


// Data Validasi
Route::get('validasi-data', [ValidasiController::class, 'index'])->middleware(['auth']);
Route::get('blangko-ijazah', [ValidasiController::class, 'blangkoijazah'])->middleware(['auth']);
Route::get('blangko-transkip', [ValidasiController::class, 'blangkoTranskip'])->middleware(['auth']);


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
