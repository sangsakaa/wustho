<?php

use App\Http\Controllers\AbsensikelasController;
use App\Http\Controllers\Admin\BulkAccountController;
use App\Http\Controllers\Admin\RoleManagementController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\UserPermissionController;
use App\Http\Controllers\ApiSiswaController;
use App\Http\Controllers\AsramaController;
use App\Http\Controllers\AsramasiswaController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\KalenderPendidikanController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\KelasmiController;
use App\Http\Controllers\KenaikanKelasController;
use App\Http\Controllers\LembagaController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\LulusanCotroller;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\PararelController;
use App\Http\Controllers\PelanggaranController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\PerangkatController;
use App\Http\Controllers\PeriodeController;
use App\Http\Controllers\PresensiGuruController;
use App\Http\Controllers\PresensikelasController;
use App\Http\Controllers\QrcodeController;
use App\Http\Controllers\RaportController;
use App\Http\Controllers\RekapAsamaController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SeleksiController;
use App\Http\Controllers\SesiasramaController;
use App\Http\Controllers\SesikelasController;
use App\Http\Controllers\SesiPerangkatController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\TranskipController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserguruController;
use App\Http\Controllers\ValidasiController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| 1. RUTE HALAMAN UTAMA & PUBLIK (PUBLIC ROUTES)
|--------------------------------------------------------------------------
*/

Route::post('/periode/set-active', [PeriodeController::class, 'setActive'])
    ->name('periode.set-active');
Route::get('/', function () {
    $dataNIS = collect();
    if (request('cari')) {
        $dataNIS = DB::table('siswa')
            ->leftJoin('nis', 'nis.siswa_id', '=', 'siswa.id')
            ->leftJoin('daftar_lulusan', 'daftar_lulusan.pesertakelas_id', '=', 'siswa.id')
            ->select('siswa.id', 'siswa.nama_siswa', 'nis.nis', 'daftar_lulusan.nomor_ijazah')
            ->where('nis.nis', 'like', '%' . request('cari') . '%')
            ->orderBy('siswa.nama_siswa')
            ->get();
    }
    return view('welcome', compact('dataNIS'));
});

Route::get('/nism-siswa', function () {
    $dataNIS = collect();
    if (request('cari')) {
        $dataNIS = DB::table('siswa')
            ->leftJoin('nis', 'nis.siswa_id', '=', 'siswa.id')
            ->leftJoin('daftar_lulusan', 'daftar_lulusan.pesertakelas_id', '=', 'siswa.id')
            ->select('siswa.id', 'siswa.nama_siswa', 'nis.nis', 'daftar_lulusan.nomor_ijazah')
            ->where('nis.nis', 'like', '%' . request('cari') . '%')
            ->orderBy('siswa.nama_siswa')
            ->get();
    }
    return view('welcome', compact('dataNIS'));
});


/*
|--------------------------------------------------------------------------
| 2. RUTE OTENTIKASI & MANAJEMEN USER GUEST/UMUM
|--------------------------------------------------------------------------
*/
Route::get('/manajemen-user', [UserManagementController::class, 'index']);
Route::get('/has-role', [RoleManagementController::class, 'index']);
Route::post('/roles/assign', [RoleManagementController::class, 'assign']);
Route::post('/bulk/siswa', [BulkAccountController::class, 'createStudentAccounts']);
Route::post('/bulk/guru', [BulkAccountController::class, 'createTeacherAccounts']);

Route::get('/register-list', [RegisteredUserController::class, 'index'])->name('register.index');
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);
Route::delete('/register/{user}', [RegisteredUserController::class, 'destroy'])->name('register.destroy');


/*
|--------------------------------------------------------------------------
| 3. MULTI-ROLE DASHBOARD (ADMIN, GURU, USER)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::middleware(['auth'])->group(function () {
    // Dashboard & Profil User/Siswa Umum
    Route::get('/userdashboard', [UserController::class, 'DashboardUser'])->name('userdashboard');
    Route::get('/user', [UserController::class, 'Personal'])->name('user');
    Route::get('/riwayatkelas', [UserController::class, 'Riwayatkelas'])->name('riwayatkelas');
    Route::get('/riwayatkehadiran', [UserController::class, 'Riwayatkehadiran'])->name('riwayatkehadiran');

    // Dashboard & Fitur Guru
    Route::get('/gurudashboard', [UserguruController::class, 'DashboardGuru'])->name('gurudashboard');
    Route::get('/nilaiperguru', [UserguruController::class, 'UserGuru'])->name('nilaiperguru');
});

// KELENDER PENDIDIKAN
Route::middleware(['auth'])->group(function () {

    // =========================
    // KALENDER PENDIDIKAN
    // =========================

    Route::get(
        '/kalender-pendidikan/pdf',
        [KalenderPendidikanController::class, 'pdf']
    )->name('kalender-pendidikan.pdf');

    Route::get(
        '/kalender-pendidikan',
        [KalenderPendidikanController::class, 'index']
    )->name('kalender-pendidikan.index');

    Route::get(
        '/kalender-pendidikan/create',
        [KalenderPendidikanController::class, 'create']
    )->name('kalender-pendidikan.create');

    Route::post(
        '/kalender-pendidikan',
        [KalenderPendidikanController::class, 'store']
    )->name('kalender-pendidikan.store');

    Route::get(
        '/kalender-pendidikan/{kalenderPendidikan}',
        [KalenderPendidikanController::class, 'show']
    )->name('kalender-pendidikan.show');

    Route::get(
        '/kalender-pendidikan/{kalenderPendidikan}/edit',
        [KalenderPendidikanController::class, 'edit']
    )->name('kalender-pendidikan.edit');

    Route::put(
        '/kalender-pendidikan/{kalenderPendidikan}',
        [KalenderPendidikanController::class, 'update']
    )->name('kalender-pendidikan.update');

    Route::delete(
        '/kalender-pendidikan/{kalenderPendidikan}',
        [KalenderPendidikanController::class, 'destroy']
    )->name('kalender-pendidikan.destroy');
});
/*
|--------------------------------------------------------------------------
| 4. MANAJEMEN GRUP AUTHENTICATED (UMUM / REGISTER / ROLE-MANAGEMENT)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    // Lembaga
    Route::resource('lembaga', LembagaController::class);
    Route::patch('lembaga/{lembaga}/toggle', [LembagaController::class, 'toggle'])->name('lembaga.toggle');

    // Registrasi Siswa via Auth
    Route::get('/registrasi-siswa', [RegisteredUserController::class, 'index'])->name('register.index');
    Route::get('/registrasi-siswa/create', [RegisteredUserController::class, 'create'])->name('register.create');
    Route::post('/registrasi-siswa/store', [RegisteredUserController::class, 'store'])->name('register.store');
    Route::delete('/users/{user}', [RegisteredUserController::class, 'destroy'])->name('users.destroy');

    // Manajemen Duplikasi Route Registrasi / Fallback
    Route::get('/manajemen-user', [RegisteredUserController::class, 'index'])->name('admin');
    Route::get('/register-list', [RegisteredUserController::class, 'index'])->name('register.index');
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store'])->name('register.store');
    Route::get('manajemen', [RegisteredUserController::class, 'manajemen'])->name('manajemen');
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');

    // Pembuatan Akun Kolektif
    Route::get('/buatakunsiswa', [RegisteredUserController::class, 'buatAkunSiswa']);
    Route::get('/buatakunguru', [RegisteredUserController::class, 'buatAkunGuru']);
});

// Quick Create (Luar Middleware)
Route::post('/registrasi-siswa/quick-create/{siswa}', [RegisteredUserController::class, 'quickCreate'])->name('register.quick');


/*
|--------------------------------------------------------------------------
| 5. MANAJEMEN ROLE & PERMISSION (HAS-ROLE & ADMIN AREA)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('has-role')->name('has-role.')->group(function () {
    Route::get('/', [RegisteredUserController::class, 'HasRole'])->name('index');
    Route::post('/store-role', [RegisteredUserController::class, 'storeRole'])->name('store-role');
    Route::post('/assign', [RegisteredUserController::class, 'storeHasRole'])->name('assign');
    Route::post('admin', [RegisteredUserController::class, 'role_has_permission']);
});

Route::delete('admin/{user}', [RegisteredUserController::class, 'destroy']);
Route::post('/roles/assign', [RoleManagementController::class, 'assign'])->name('roles.assign');

// Namespace Khusus Admin
Route::middleware(['auth', 'role:admin|super admin'])->prefix('admin')->name('admin.')
    ->group(function () {
        Route::get('/users', [UserManagementController::class, 'index'])->name('users.index');
        Route::delete('/users/{user}', [UserManagementController::class, 'destroy'])->name('users.destroy');
        Route::get('/roles', [RoleManagementController::class, 'index'])->name('roles.index');
        Route::post('/roles/assign', [RoleManagementController::class, 'assign'])->name('roles.assign');
        Route::post('/bulk/siswa', [BulkAccountController::class, 'createStudentAccounts'])->name('bulk.siswa');
        Route::post('/bulk/guru', [BulkAccountController::class, 'createTeacherAccounts'])->name('bulk.guru');

        // User Permissions
        Route::get('/user-permissions', [UserPermissionController::class, 'index'])->name('permissions.index');
        Route::post('/admin/user-permissions/{user}', [UserPermissionController::class, 'update']); // Penyesuaian string internal asal tetap ada
        Route::put('/user-permissions/{user}', [UserPermissionController::class, 'update'])->name('permissions.update');
        Route::get('/permissions', [UserPermissionController::class, 'index'])->name('permissions.index');
        Route::put('/permissions/{role}', [UserPermissionController::class, 'update'])->name('permissions.update');
    });

Route::post('/admin/users/{user}/assign-role', [UserManagementController::class, 'assignRole'])->name('admin.users.assign-role');
Route::get('/admin/user-permissions', [UserPermissionController::class, 'index']);
Route::post('/admin/user-permissions/{user}', [UserPermissionController::class, 'update']);


/*
|--------------------------------------------------------------------------
| 6. KESISWAAN (MANAJEMEN SISWA & BIODATA)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('siswa', [SiswaController::class, 'index'])->name('siswa.index');
    Route::get('siswa/{siswa}', [SiswaController::class, 'show']);
    Route::get('biodata/{siswa}', [SiswaController::class, 'biodata']);
    Route::get('transkip/{siswa}', [SiswaController::class, 'transkip']);

    Route::get('/siswa/export/excel', [SiswaController::class, 'exportExcel'])->name('siswa.export.excel');

    // NIS Siswa
    Route::get('nis/{siswa}', [SiswaController::class, 'nis']);
    Route::get('nis/{nis}/edit', [SiswaController::class, 'editNis']);
    Route::patch('nis/{nis}', [SiswaController::class, 'UpdateNis']);
    Route::post('nis/{siswa}', [SiswaController::class, 'storeNis']);
    Route::delete('nis/{nis}', [SiswaController::class, 'destroyNis']);

    // Status Pengamal & Anak
    Route::get('statuspengamal/{siswa}', [SiswaController::class, 'statuspengamal']);
    Route::post('statuspengamal/{siswa}', [SiswaController::class, 'storeSP']);
    Route::delete('statuspengamal/{siswa}', [SiswaController::class, 'destroySP'])->name('statuspengamal.destroy');
    Route::get('statusanak/{siswa}', [SiswaController::class, 'statusanak']);
    Route::post('statusanak/{siswa}', [SiswaController::class, 'storeSA']);
    Route::delete('statusanak/{statusanak}', [SiswaController::class, 'HapusStatusAnaka']);

    // CRUD Siswa Utama
    Route::get('addsiswa', [SiswaController::class, 'create']);
    Route::post('siswa', [SiswaController::class, 'store']);
    Route::delete('siswa/{siswa}', [SiswaController::class, 'destroy']);
    Route::get('siswa/{siswa}/edit', [SiswaController::class, 'edit']);
    Route::patch('siswa/{siswa}', [SiswaController::class, 'update']);
});


/*
|--------------------------------------------------------------------------
| 7. KURIKULUM (KELAS, KELAS MI, & PESERTA KELAS)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    // Manajemen Kelas Umum
    Route::get('kelas', [KelasController::class, 'index'])->name('kelas');
    Route::get('addkelas', [KelasController::class, 'create'])->name('addkelas');
    Route::get('kelas/{kelas}/edit', [KelasController::class, 'edit']);
    Route::post('kelas', [KelasController::class, 'store'])->name('kelas');
    Route::delete('kelas/{kelas}', [KelasController::class, 'destroy']);
    Route::post('pesertakolektif', [KelasController::class, 'StoreKolektif'])->name('pesertakolektif');
    Route::get('pesertakolektif/{kelasmi}', [KelasController::class, 'pesertakolektif']);

    // Manajemen Kelas MI
    Route::get('kelas_mi', [KelasmiController::class, 'index'])->name('kelas_mi.index');
    Route::get('addkelas_mi', [KelasmiController::class, 'create'])->name('addkelas_mi');
    Route::post('kelas_mi', [KelasmiController::class, 'store'])->name('kelas_mi');
    Route::get('kelas_mi/{kelasmi}/edit', [KelasmiController::class, 'edit']);
    Route::delete('kelas_mi/{kelasmi}', [KelasmiController::class, 'destroy']);
    Route::patch('kelas_mi/{kelasmi}', [KelasmiController::class, 'update']);
    Route::get('rekap-kelas-mi', [KelasmiController::class, 'rekapKelas']);
    Route::post('/kelasmi/generate-periode', [KelasmiController::class, 'generatePeriodeBerikutnya'])->name('kelasmi.generatePeriode');
    // web.php

    Route::post(
        '/kelasmi/generate-kelas-satu',
        [KelasmiController::class, 'generateKelasSatu']
    )->name('kelasmi.generate-kelas-satu');

    // Peserta Kelas MI Detail
    Route::get('pesertakelas/{kelasmi}', [KelasmiController::class, 'show'])->name('pesertakelas');
    Route::delete('pesertakelas/{pesertakelas}', [KelasmiController::class, 'hapus'])->name('pesertakelas');
    Route::get('pesertakelas/{pesertakelas}/edit', [KelasmiController::class, 'editpesertakelas']);
    Route::patch('pesertakelas/{pesertakelas}', [KelasmiController::class, 'storepesertakelas']);

    // Kenaikan Kelas
    Route::get('/kenaikan-kelas', [KenaikanKelasController::class, 'index']);
    Route::post('/kenaikan-kelas', [KenaikanKelasController::class, 'proses'])->name('kenaikan.proses');
});


/*
|--------------------------------------------------------------------------
| 8. AKADEMIK (MATA PELAJARAN & NILAI)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    // Mata Pelajaran (Mapel)
    Route::get('mapel', [MapelController::class, 'index'])->name('mapel');
    Route::get('/mapel', [MapelController::class, 'index'])->name('mapel.index');
    Route::get('/mapel/{mapel}', [MapelController::class, 'show'])->name('mapel.show');
    Route::get('edit-mapel/{mapel}', [MapelController::class, 'edit']);
    Route::get('addmapel', [MapelController::class, 'create']);
    Route::post('mapel', [MapelController::class, 'store']);
    Route::patch('mapel/{mapel}', [MapelController::class, 'update']);
    Route::delete('mapel/{mapel}', [MapelController::class, 'destroy']);
    Route::get('/mapel/laporan/pdf', [MapelController::class, 'laporanPdf']);
    Route::post('/mapel/{mapel}/pengampu', [MapelController::class, 'storePengampu'])->name('mapel.pengampu.store');
    Route::delete('/mapel/{mapel}/pengampu/{guru}', [MapelController::class, 'destroyPengampu'])->name('mapel.pengampu.destroy');
    Route::post('/mapel/{mapel}/generate-pengampu', [MapelController::class, 'generatePengampuFromJadwal'])->name('mapel.pengampu.generate');
    Route::post('/mapel/generate-pengampu', [MapelController::class, 'generateAllPengampuFromJadwal'])->name('mapel.generate-pengampu');

    // Manajemen Nilai
    Route::get('nilaimapel', [NilaiController::class, 'index'])->name('nilaimapel');
    Route::get('progress-nilai', [NilaiController::class, 'progress'])->name('progress-nilai');
    Route::post('/nilai/generate', [NilaiController::class, 'generateNilaiMapelFromJadwal']);
    Route::get('nilai/{nilaimapel}', [NilaiController::class, 'show']);
    Route::post('nilai', [NilaiController::class, 'store'])->name('nilai');
    Route::get('nilai', [NilaiController::class, 'nilaipersiswa'])->name('nilaipersiswa');
    Route::post('nilaimapel', [NilaiController::class, 'storeNilaimapel'])->name('nilaimapel');
    Route::delete('nilaimapel/{nilaimapel}', [NilaiController::class, 'destroy']);
});


/*
|--------------------------------------------------------------------------
| 9. JADWAL PELAJARAN & PLOTING GURU
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('Daftar-Jadwal', [JadwalController::class, 'Jadwal'])->name('Daftar-Jadwal');
    Route::post('Daftar-Jadwal', [JadwalController::class, 'StoreJadwal']);
    Route::get('jadwal-guru/{jadwal}', [JadwalController::class, 'DaftarJadwal']);
    Route::post('jadwal-guru/{jadwal}', [JadwalController::class, 'StoreDaftarJadwal']);
    Route::get('/cetak-jadwal-kolektif', [JadwalController::class, 'JadwalKolektif'])->name('cetak-jadwal-kolektif');
    Route::get('cetak-jadwal-1', [JadwalController::class, 'CetakJadwal1']);
    Route::get('edit-jadwal/{daftar_Jadwal}', [JadwalController::class, 'editJadwal']);
    Route::patch('edit-jadwal/{daftar_Jadwal}/edit', [JadwalController::class, 'updateJadwal']);
    Route::get('/get-guru-by-mapel', [JadwalController::class, 'getGuruByMapel']);
    Route::get('laporan-poling-guru', [JadwalController::class, 'LaporanPloting']);
    Route::get('laporan-poling-guru-kelas', [JadwalController::class, 'LaporanPlotingKelas']);
    Route::get('/laporan-ploting-pdf', [JadwalController::class, 'LaporanPlotingKelasPDF'])->name('laporan.ploting.pdf');
    Route::delete('jadwal-guru/{daftar_Jadwal}', [JadwalController::class, 'destroyGuru']);
    Route::delete('Daftar-Jadwal/{jadwal}', [JadwalController::class, 'destroy']);
});


/*
|--------------------------------------------------------------------------
| 10. MANAJEMEN GURU, PERANGKAT & JABATAN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    // Profil & Data Guru Utama
    Route::get('guru', [GuruController::class, 'index'])->name('guru');
    Route::get('guru/{guru}', [GuruController::class, 'show']);
    Route::get('addGuru', [GuruController::class, 'create']);
    Route::post('guru', [GuruController::class, 'store']);
    Route::delete('guru/{guru}', [GuruController::class, 'destroy']);
    Route::patch('guru/{guru}', [GuruController::class, 'update']);
    Route::get('guru/{guru}/edit', [GuruController::class, 'edit']);

    // NIG (Nomor Induk Guru)
    Route::get('nig/{guru}', [GuruController::class, 'NIS'])->name('nis');
    Route::post('nig/{guru}', [GuruController::class, 'nisGuru']);
    Route::delete('nig/{nig}', [GuruController::class, 'destroyNig']);
    Route::post('/guru/nig', [GuruController::class, 'storeNig']);
    Route::post('/guru/generate-kolektif-nig', [GuruController::class, 'generateKolektifNig']);

    // Data Perangkat Madrasah/Sekolah
    Route::get('data-perangkat', [PerangkatController::class, 'index'])->name('data-perangkat');
    Route::get('form-perangkat', [PerangkatController::class, 'create'])->name('form-perangkat');
    Route::get('detail-perangkat/{perangkat}', [PerangkatController::class, 'view']);
    Route::post('detail-perangkat/{perangkat}', [PerangkatController::class, 'store_jabatan']);
    Route::get('edit-form-perangkat/{perangkat}/edit', [PerangkatController::class, 'edit']);
    Route::patch('edit-form-perangkat/{perangkat}/edit', [PerangkatController::class, 'update']);
    Route::post('data-perangkat', [PerangkatController::class, 'store'])->name('form-perangkat');
    Route::post('/perangkat/{perangkat}/update-jabatan', [PerangkatController::class, 'updateJabatan'])
        ->name('perangkat.update-jabatan');
});

// Jabatan (Luar middleware auth asli)
Route::get('/jabatan', [JabatanController::class, 'index']);
Route::post('/jabatan', [JabatanController::class, 'store']);
Route::get('/jabatan/{id}/edit', [JabatanController::class, 'edit']);
Route::put('/jabatan/{id}', [JabatanController::class, 'update']);
Route::delete('/jabatan/{id}', [JabatanController::class, 'destroy']);



/*
|--------------------------------------------------------------------------
| 11. PRESENSI KELAS, PRESENSI GURU & SESI PERANGKAT
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    // Sesi & Presensi Guru
    Route::get('sesi-presensi-guru', [PresensiGuruController::class, 'index'])->name('sesi-presensi-guru');
    Route::post('sesi-presensi-guru', [PresensiGuruController::class, 'store']);
    Route::get('sesi-presensi-guru/{sesi_Kelas_Guru}', [PresensiGuruController::class, 'DaftarGuru'])->where('sesi_Kelas_Guru', '[0-9]+');
    Route::post('sesi-presensi-guru/{sesi_Kelas_Guru}', [PresensiGuruController::class, 'AbsenGuru']);
    Route::get('laporan-harian-guru', [PresensiGuruController::class, 'LaporanHarian'])->name('laporan-harian-guru');
    Route::get('laporan-semester-guru', [PresensiGuruController::class, 'laporanSemester'])->name('laporan-semester-guru');
    Route::get('/laporan-guru/pdf', [PresensiGuruController::class, 'laporanSemesterPdf']);
    Route::delete('sesi-presensi-guru/{sesi_Kelas_Guru}', [PresensiGuruController::class, 'DeleteSesi']);
    Route::get('sesi-presensi-guru/rekap', [PresensiGuruController::class, 'rekapSesi']);

    // Presensi Kelas Siswa
    Route::get('presensikelas', [PresensikelasController::class, 'index']);
    Route::get('presensikelas/{kelasmi}', [PresensikelasController::class, 'show']);
    Route::post('presensikelas', [PresensikelasController::class, 'store']);

    // Sesi Kelas & Absensi Detail
    Route::get('sesikelas', [SesikelasController::class, 'index'])->name('sesikelas');
    Route::post('sesikelas', [SesikelasController::class, 'store']);
    Route::delete('sesikelas/{sesikelas}', [SesikelasController::class, 'destroy'])->where('sesikelas', '[0-9]+');
    Route::get('sesikelas/rekap', [SesikelasController::class, 'rekapSesi']);
    Route::get('absensikelas/{sesikelas}', [AbsensikelasController::class, 'index'])->where('sesikelas', '[0-9]+');
    Route::post('absensikelas', [AbsensikelasController::class, 'store']);

    // Blanko & Rekap Absensi
    Route::get('absensikelas/blanko', [AbsensikelasController::class, 'blanko'])->name('absensikelas/blanko');
    Route::get('/absensikelas/blanko/pdf', [AbsensiKelasController::class, 'cetakBlankoPdf'])
        ->name('absensikelas.blanko.pdf');
    Route::get('blankoHarian', [AbsensikelasController::class, 'blankoLApHarian'])->name('blankoHarian');
    Route::get('absensikelas/rekap-per-hari', [AbsensikelasController::class, 'rekapPerHari'])->name('absensikelas/rekap-per-hari');
    Route::get('absensikelas/rekap-per-bulan', [AbsensikelasController::class, 'rekapPerBulan'])->name('absensikelas/rekap-per-bulan');
    Route::get('absensikelas/rekap-per-bulan-asrama', [AbsensikelasController::class, 'rekapPerBulanAsrama'])->name('absensikelas/rekap-per-bulan-asrama');
    Route::get('absensikelas/rekap-semester', [AbsensikelasController::class, 'rekapSemester'])->name('absensikelas/rekap-semester');
    Route::get('blanko-pernyataan', [AbsensikelasController::class, 'pernyataan'])->name('blanko-pernyataan');
});

// Bulk Delete Presensi / Sesi & Sesi Perangkat
Route::delete('/sesi-presensi-guru', [PresensiGuruController::class, 'bulkDelete']);
Route::delete('/sesikelas/bulk-delete', [AbsensikelasController::class, 'bulkDelete']);
Route::post('/sesikelas/bulk-toggle', [SesikelasController::class, 'bulkToggleSession'])->name('sesi.bulkToggle');
Route::post('/sesikelas/{id}/toggle', [SesikelasController::class, 'toggle'])->name('sesi.toggle');

Route::get('sesi-perangkat', [SesiPerangkatController::class, 'sesiPerangkat'])->name('sesi-perangkat');
Route::post('sesi-perangkat', [SesiPerangkatController::class, 'buatSesi']);
Route::get('/daftar-sesi-perangkat/{sesiPerangkat}', [SesiPerangkatController::class, 'daftarSesi']);
Route::post('/daftar-sesi-perangkat/{sesiPerangkat}', [SesiPerangkatController::class, 'StoredaftarSesi']);
Route::get('laporan-harian-perangkat', [SesiPerangkatController::class, 'LaporanHarian']);
Route::get('laporan-Bulanan-perangkat', [SesiPerangkatController::class, 'LaporanBulanan']);
Route::get('rekap-Bulanan', [SesiPerangkatController::class, 'rekapSesiPerangkat']);

/*
|--------------------------------------------------------------------------
| 12. QR CODE SYSTEM & REAL-TIME MONITORING
|--------------------------------------------------------------------------
*/
Route::get('/qr', [QrcodeController::class, 'index'])->name('qr.index');
Route::post('/qr/generate/{id}', [QrcodeController::class, 'generate'])->name('qr.siswa');
Route::post('/qr/generate-all', [QrcodeController::class, 'generateAll'])->name('qr.generate.all');
Route::get('/kartu-login/pdf/all', [QrcodeController::class, 'kartuLoginPdfAll'])->name('kartu.login.all');
Route::get('/kartu-login/kelas/{kelas}', [QrcodeController::class, 'kartuLoginPdfKelas'])->name('kartu.login.kelas');
Route::get('/kartu-login/{id}', [QrcodeController::class, 'kartuLoginPdf'])->name('kartu.login.pdf');

Route::get('/scan-qr', [QrcodeController::class, 'scan'])->name('qr.scan');
Route::post('/scan-qr/store', [QrcodeController::class, 'store'])->name('qr.store');
Route::post('/qr/scan', [QrcodeController::class, 'store'])->name('qr.scan.store');
Route::post('/scan-qr/store', [QrcodeController::class, 'store'])->name('qr.scan.store');

Route::get('/absensi/monitor/{id}', [QrcodeController::class, 'monitor']);
Route::post('/absensi/manual', [QrcodeController::class, 'manualAbsen'])->name('absen.manual');
Route::delete('/qr/undo/{id}', [QrcodeController::class, 'undoAbsen']);
Route::get('/qr/today-log', [QrcodeController::class, 'todayLog']);


/*
|--------------------------------------------------------------------------
| 13. KEPESANTREAN & ASRAMA (DORMITORY MANAGEMENT)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    // Gedung/Kamar Asrama
    Route::get('asrama', [AsramaController::class, 'index'])->name('asrama');
    Route::post('asrama', [AsramaController::class, 'store'])->name('asrama');
    Route::delete('asrama/{asrama}', [AsramaController::class, 'destroy']);
    Route::delete('/asramasiswa/bulk-delete', [AsramasiswaController::class, 'bulkDelete']);
    Route::get('addasrama', [AsramaController::class, 'create'])->name('addasrama');
    Route::delete('/asramasiswa/delete-selected', [AsramaController::class, 'deleteSelected']);
    Route::delete('asramasiswa/{asramasiswa}', [AsramasiswaController::class, 'destroy'])
        ->name('asramasiswa.destroy');
    Route::post('/pesertaasrama/bulk-delete-peserata', [AsramasiswaController::class, 'bulkDelete']);
    Route::delete('/bulk-delete-asrama', [AsramasiswaController::class, 'bulkDeleteasrama'])
        ->name('bulk.delete.asrama');

    Route::post('/asrama/transfer', [AsramasiswaController::class, 'transferAsrama'])
        ->name('asrama.transfer');

    // Penempatan Siswa di Asrama
    Route::get('asramasiswa', [AsramasiswaController::class, 'index'])->name('asramasiswa');
    Route::post('asramasiswa', [AsramasiswaController::class, 'store']);
    Route::patch('asramasiswa/{asramasiswa}', [AsramasiswaController::class, 'update']);
    Route::get('asramasiswa/{asramasiswa}/edit', [AsramasiswaController::class, 'edit']);
    Route::get('addasramasiswa', [AsramasiswaController::class, 'create']);
    Route::get('pesertaasrama/{asramasiswa}', [AsramasiswaController::class, 'show']);
    Route::delete('asramasiswa/{asramasiswa}', [AsramasiswaController::class, 'destroy'])->name('asramasiswa.destroy');
    Route::delete('pesertaasrama/{pesertaasrama}', [AsramasiswaController::class, 'destroyPesertaAsrama'])->name('pesertaasrama.destroy');
    Route::get('pesertaasrama/{pesertaasrama}/edit', [AsramasiswaController::class, 'editpeserta']);
    Route::get('kolektifasrama/{asramasiswa}', [AsramasiswaController::class, 'kolelktifasrama']);
    Route::post('kolektifasrama', [AsramasiswaController::class, 'StoreKolektifasrama']);
    Route::patch('pesertaasrama/pesertaasrama/{asramasiswa}', [AsramasiswaController::class, 'updatepeserta']);
    Route::patch('pesertaasrama/{pesertaasrama}', [AsramasiswaController::class, 'updatepeserta']);
    Route::post('/pesertaasrama/delete-selected', [AsramasiswaController::class, 'deleteSelected']);
    Route::post('/asramasiswa/pindah-periode', [AsramasiswaController::class, 'pindahPeriode'])->name('asramasiswa.pindahperiode');

    // Sesi & Presensi Asrama
    Route::get('sesiasrama', [SesiasramaController::class, 'index'])->name('sesiasrama');
    Route::get('sesiasrama/{sesiasrama}', [SesiasramaController::class, 'show']);
    Route::post('sesiasrama', [SesiasramaController::class, 'store']);
    Route::post('sesiasrama/presensi', [SesiasramaController::class, 'simpanpresensi']);
    Route::delete('sesiasrama/{sesiasrama}', [SesiasramaController::class, 'destroy']);
    Route::post('/sesiasrama/generate', [SesiasramaController::class, 'generate'])->name('sesiasrama.generate');
});

// Rekap & Transisi Periode Asrama
Route::post('/generate-asrama-periode', [AsramasiswaController::class, 'generatePeriodeBerikutnya']);
Route::get('rekap-harian', [RekapAsamaController::class, 'RekapHarian']);


/*
|--------------------------------------------------------------------------
| 14. EVALUASI HASIL BELAJAR (RAPORT & KELULUSAN / ALUMNI)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    // Cetak Raport & Peringkat
    Route::get('report/{pesertakelas}', [RaportController::class, 'show'])->name('report');
    Route::get('raportkelas', [RaportController::class, 'raportkelas'])->name('raportkelas');
    Route::post('raportkelas', [RaportController::class, 'raportkelas']);
    Route::get('peringkat', [RaportController::class, 'peringkat'])->name('peringkat');
    Route::post('peringkat', [RaportController::class, 'peringkat']);
    Route::get('juara-pararel', [PararelController::class, 'index']);

    Route::get('/raport/{pesertakelas}/pdf', [RaportController::class, 'pdf']);

    // Manajemen Kelulusan & Ijazah
    Route::get('lulusan', [LulusanCotroller::class, 'index'])->name('lulusan');
    Route::post('lulusan', [LulusanCotroller::class, 'store'])->name('lulusan');
    Route::get('daftar-lulusan/{lulusan}', [LulusanCotroller::class, 'daftarLulusan']);
    Route::get('kolektif-lulusan/{lulusan}', [LulusanCotroller::class, 'kolektifLulusan']);
    Route::post('kolektif-lulusan/{lulusan}', [LulusanCotroller::class, 'storeLulusan']);
    Route::delete('daftar-lulusan/{daftar_lulusan}', [LulusanCotroller::class, 'DeletePeserta']);
    Route::delete('lulusan/{lulusan}', [LulusanCotroller::class, 'Destroy']);
    Route::get('reservasi-ijazah/{daftar_lulusan}', [LulusanCotroller::class, 'edit']);
    Route::patch('daftar-lulusan/{daftar_lulusan}', [LulusanCotroller::class, 'update']);

    // Transkip Nilai Kelulusan
    Route::get('daftar-transkip', [TranskipController::class, 'index'])->name('daftar-transkip');
    Route::post('daftar-transkip', [TranskipController::class, 'store'])->name('daftar-transkip');
    Route::get('nilai_transkip/{transkip}', [TranskipController::class, 'daftarTranskip'])->name('nilai_transkip');
    Route::post('nilai_transkip/{transkip}', [TranskipController::class, 'NilaiTranskip'])->name('nilai_transkip');
    Route::delete('daftar-transkip/{transkip}', [TranskipController::class, 'DeleteTraskip']);
});

/*
|--------------------------------------------------------------------------
| 15. SELEKSI MASUK & NOMINASI (ADMISSION / SELECTION)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('daftar-seleksi', [SeleksiController::class, 'index'])->name('daftar-seleksi');
    Route::post('daftar-seleksi', [SeleksiController::class, 'store'])->name('daftar-seleksi');
    Route::get('daftar-nominasi/{nominasi}', [SeleksiController::class, 'daftarNominasi'])->name('daftar-nominasi');
    Route::get('kolektif-daftar-nominasi/{nominasi}', [SeleksiController::class, 'daftarNominasiKelektif']);
    Route::post('daftar-nominasi/{nominasi}', [SeleksiController::class, 'StoreNominasi'])->name('daftar-nominasi');
    Route::delete('daftar-seleksi/{nominasi}', [SeleksiController::class, 'destroy']);
    Route::delete('daftar-nominasi/{daftar_Nominasi}', [SeleksiController::class, 'destroyNominasi']);
});


/*
|--------------------------------------------------------------------------
| 16. VALIDASI DATA, INTEGRITAS DATA, & EXPORT-IMPORT
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('validasi-data', [ValidasiController::class, 'index']);
    Route::get('/validasi-data/pdf', [ValidasiController::class, 'pdf']);
    Route::get('blangko-ijazah/{lulusan}', [ValidasiController::class, 'blangkoijazah']);
    Route::get('blangko-transkip/{lulusan}', [ValidasiController::class, 'blangkoTranskip']);
    Route::get('/validasi-kelulusan', [ValidasiController::class, 'ValidasiKelulusan'])->name('validasi.kelulusan');

    // Export Import Data
    Route::get('Exports-data', [ExportController::class, 'Exports'])->name('Exports-data');
});

Route::get('/export-siswa', [ExportController::class, 'export'])->name('export.siswa');
Route::post('/import-siswa', [ExportController::class, 'importSiswa'])->name('import.siswa');


/*
|--------------------------------------------------------------------------
| 17. KEGIATAN & PELANGGARAN SISWA (EXTRACURRICULAR / DISCIPLINE)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    // Agenda Kegiatan
    Route::get('kegiatan', [KegiatanController::class, 'index'])->name('kegiatan');
    Route::get('kegiatan/{kegiatan}/edit', [KegiatanController::class, 'edit']);
    Route::post('kegiatan', [KegiatanController::class, 'store']);
    Route::get('addkegiatan', [KegiatanController::class, 'create']);
    Route::delete('kegiatan/{kegiatan}', [KegiatanController::class, 'destroy']);
    Route::patch('kegiatan/{kegiatan}', [KegiatanController::class, 'update']);

    // Pelanggaran Siswa
    Route::get('addpelanggaran', [PelanggaranController::class, 'create']);
    Route::post('addpelanggaran', [PelanggaranController::class, 'store']);
    Route::delete('addpelanggaran/{pelanggaran}', [PelanggaranController::class, 'destroy']);
});


/*
|--------------------------------------------------------------------------
| 18. SYSTEM SETTINGS, PERIODE AKADEMIK, UTILITY & PDF GENERATOR
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('pengaturan', [PengaturanController::class, 'pengaturan'])->name('pengaturan');
    Route::get('semester', [PengaturanController::class, 'semester'])->name('semester');
    Route::get('cardlogin', [PengaturanController::class, 'cardlogin'])->name('cardlogin');
    Route::get('sap', [PengaturanController::class, 'sap'])->name('sap');
    Route::get('live-siswa', [PengaturanController::class, 'testLive']);
    // Route::get('kalender-pendidikan', [PengaturanController::class, 'kalender']);

    // Ploting Konfigurasi
    Route::get('plotingkelas', [PengaturanController::class, 'plotingkelas']);
    Route::get('ploting-kelas-jenis-kelamin', [PengaturanController::class, 'plotingJk']);

    // Periode Operasional Madrasah
    Route::get('periode', [PengaturanController::class, 'periode'])->name('periode');
    Route::post('periode', [PengaturanController::class, 'storeperiode']);
    Route::delete('periode/{periode}', [PengaturanController::class, 'deleteperiode']);
    Route::post('/periode/aktifkan/{id}', [PengaturanController::class, 'aktifkan']);

    // Autentikasi Periode Session
    Route::post('setperiode', [AuthenticatedSessionController::class, 'setPeriode'])->name('setperiode');

    // Report Kehadiran Global
    Route::get('Laporan-Kehadiran', [ReportController::class, 'LapKehadiran'])->name('Laporan-Kehadiran');
});

// Periode & System Utility Global
Route::get('/periode/{id}', [PengaturanController::class, 'detailPeriode']);
Route::delete('/periode/{id}', [PengaturanController::class, 'deleteperiode']);
Route::post('/periode/generate', [PengaturanController::class, 'generatePeriode']);
Route::get('download_file', [PengaturanController::class, 'download_file']);
Route::post('/delete-records', [PengaturanController::class, 'deleteRecordsById']);

// Ekstraksi PDF Bebas Hambatan Middleware
Route::get('/generate-pdf/{tgl}', [AbsensikelasController::class, 'generatePdf']);
Route::get('/layout-pdf', [AbsensikelasController::class, 'layoutPDF']);


// log
Route::middleware(['auth'])->group(function () {
    Route::get('/activity-logs', [LogController::class, 'index'])
        ->name('activity.logs');
});


/**
 * =========================
 * CALON SISWA ROUTES
 * =========================
 */

Route::prefix('calon-siswa')->group(function () {
    Route::get('/', [ApiSiswaController::class, 'view'])->name('calon-siswa');
});
Route::get('/calon-siswa/sync', [ApiSiswaController::class, 'liveSync'])->name('calon-siswa.sync');
Route::get('/debug-sync', [ApiSiswaController::class, 'debugSync'])->name('debug.sync');


Route::post('/calon-siswa/{id}/push', [ApiSiswaController::class, 'pushToSiswa']);
Route::post('/calon-siswa/{calon}/reset-status', [ApiSiswaController::class, 'resetStatus']);

// cek store hosting

Route::get('/disk-check', function () {

    $path = base_path(); // lokasi aplikasi Laravel

    $total = disk_total_space($path);
    $free  = disk_free_space($path);
    $used  = $total - $free;

    return response()->json([
        'path' => $path,
        'total_bytes' => $total,
        'used_bytes' => $used,
        'free_bytes' => $free,

        'total_gb' => round($total / 1024 / 1024 / 1024, 2),
        'used_gb'  => round($used / 1024 / 1024 / 1024, 2),
        'free_gb'  => round($free / 1024 / 1024 / 1024, 2),
    ]);
});


Route::get('/php-info-test', function () {
    return [
        'PHP_VERSION'  => PHP_VERSION,
        'PHP_INT_SIZE' => PHP_INT_SIZE,
        'PHP_INT_MAX'  => PHP_INT_MAX,
    ];
});
require __DIR__ . '/auth.php';

