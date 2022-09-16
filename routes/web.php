<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\AsramaController;
use App\Http\Controllers\KelasmiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\AsramaSiswaController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\RaportController;
use App\Http\Controllers\SesiasramaController;

Route::get('/', function () {
    return view('welcome');
});

// CONTROLLER SISWA
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');
Route::get('siswa', [SiswaController::class, 'index'])->middleware(['auth'])->name('siswa');
Route::get('siswa/{siswa}', [SiswaController::class, 'show']);
Route::get('biodata/{siswa}', [SiswaController::class, 'biodata']);
Route::get('transkip/{pesertakelas}', [SiswaController::class, 'transkip']);
Route::get('nis/{siswa}', [SiswaController::class, 'nis']);
Route::get('addsiswa', [SiswaController::class, 'create']);
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
Route::get('pesertakolektif', [KelasController::class, 'pesertakolektif'])->middleware(['auth']);
// CONTROLLER KELAS MI
Route::get('kelas_mi', [KelasmiController::class, 'index'])->middleware(['auth'])->name('kelas_mi');
Route::get('addkelas_mi', [KelasmiController::class, 'create'])->middleware(['auth'])->name('addkelas_mi');
Route::post('kelas_mi', [KelasmiController::class, 'store'])->middleware(['auth'])->name('kelas_mi');
Route::delete('kelas_mi/{kelasmi}', [KelasmiController::class, 'destroy'])->middleware(['auth']);
// peseta kelas
Route::get('pesertakelas/{kelasmi}', [KelasmiController::class, 'show'])->middleware(['auth'])->name('pesertakelas');
Route::delete('pesertakelas/{pesertakelas}', [KelasmiController::class, 'hapus'])->middleware(['auth'])->name('pesertakelas');

// Controller nilai
Route::get('nilaimapel', [NilaiController::class, 'index'])->middleware(['auth'])->name('nilaimapel');
Route::get('nilai/{nilaimapel}', [NilaiController::class, 'show'])->middleware(['auth']);
Route::post('nilai', [NilaiController::class, 'store'])->middleware(['auth'])->name('nilai');
Route::post('nilaimapel', [NilaiController::class, 'storeNilaimapel'])->middleware(['auth'])->name('nilaimapel');
Route::delete('nilaimapel/{nilaimapel}', [NilaiController::class, 'destroy'])->middleware(['auth']);
// Controller Asrama
Route::get('asrama', [AsramaController::class, 'index'])->middleware(['auth'])->name('asrama');
Route::post('asrama', [AsramaController::class, 'store'])->middleware(['auth'])->name('asrama');
Route::delete('asrama/{asrama}', [AsramaController::class, 'destroy'])->middleware(['auth']);
Route::get('addasrama', [AsramaController::class, 'create'])->middleware(['auth'])->name('addasrama');
// Controller Asrama Siswa
Route::get('asramasiswa', [AsramaSiswaController::class, 'index'])->middleware(['auth'])->name('asramasiswa');
Route::post('asramasiswa', [AsramaSiswaController::class, 'store'])->middleware(['auth']);
Route::patch('asramasiswa/{asramasiswa}', [AsramaSiswaController::class, 'update']);
Route::get('asramasiswa/{asramasiswa}/edit', [AsramaSiswaController::class, 'edit'])->middleware(['auth']);
Route::get('addasramasiswa', [AsramaSiswaController::class, 'create'])->middleware(['auth']);
Route::get('pesertaasrama/{asramasiswa}', [AsramaSiswaController::class, 'show'])->middleware(['auth']);
Route::delete('asramasiswa/{asramasiswa}', [AsramaSiswaController::class, 'destroy'])->middleware(['auth']);
Route::delete('pesertaasrama/{pesertaasrama}', [AsramaSiswaController::class, 'PesertaAsrama'])->middleware(['auth']);
Route::get('kolektifasrama', [AsramaSiswaController::class, 'kolelktifasrama'])->middleware(['auth']);
Route::post('kolektifasrama', [AsramaSiswaController::class, 'StoreKolektifasrama'])->middleware(['auth']);
// Controller Guru
Route::get('guru', [GuruController::class, 'index'])->middleware(['auth'])->name('guru');
Route::get('guru/{guru}', [GuruController::class, 'show'])->middleware(['auth']);
Route::get('addGuru', [GuruController::class, 'create'])->middleware(['auth']);
Route::post('guru', [GuruController::class, 'store'])->middleware(['auth']);
Route::delete('guru/{guru}', [GuruController::class, 'destroy'])->middleware(['auth']);
Route::patch('guru/{guru}', [GuruController::class, 'update'])->middleware(['auth']);
Route::get('guru/{guru}/edit', [GuruController::class, 'edit'])->middleware(['auth']);

// Controller Raport
Route::get('report/{pesertakelas}', [RaportController::class, 'show'])->middleware(['auth'])->name('report');

// Controller Mata Pelajaran
Route::get('mapel', [MapelController::class, 'index'])->middleware(['auth'])->name('mapel');
Route::post('mapel', [MapelController::class, 'store'])->middleware(['auth']);

// Controller Pengaturan
Route::get('pengaturan', [PengaturanController::class, 'pengaturan'])->middleware(['auth'])->name('pengaturan');
Route::get('semester', [PengaturanController::class, 'semester'])->middleware(['auth'])->name('semester');
Route::get('periode', [PengaturanController::class, 'periode'])->middleware(['auth'])->name('periode');
Route::post('periode', [PengaturanController::class, 'storeperiode'])->middleware(['auth']);
Route::delete('periode/{periode}', [PengaturanController::class, 'deleteperiode'])->middleware(['auth']);

// Controller Sesi Asrama

Route::get('sesiasrama', [SesiasramaController::class, 'index'])->middleware(['auth'])->name('sesiasrama');
Route::get('sesiasrama/{sesiasrama}', [SesiasramaController::class, 'show'])->middleware(['auth']);
Route::post('sesiasrama', [SesiasramaController::class, 'store'])->middleware(['auth']);
Route::post('sesiasrama/presensi', [SesiasramaController::class, 'simpanpresensi'])->middleware(['auth']);
Route::delete('sesiasrama/{sesiasrama}', [SesiasramaController::class, 'destroy'])->middleware(['auth']);

require __DIR__ . '/auth.php';
