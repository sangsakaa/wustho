<?php

use App\Http\Controllers\Api\ApiGuruController;
use App\Http\Controllers\Api\ApiSiswaController;
use App\Http\Controllers\Api\AttendanceController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\SessionController;
use App\Http\Controllers\QrcodeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Public API
|--------------------------------------------------------------------------
*/

Route::get('/getDataSiswa', [ApiSiswaController::class, 'getDataSiswa']);
Route::get('/data-asrama', [ApiSiswaController::class, 'dataAsrama']);
Route::get('/getDataGuru', [ApiGuruController::class, 'getDataGuru']);

/*
|--------------------------------------------------------------------------
| API V1
|--------------------------------------------------------------------------
*/

Route::prefix('v1')->group(function () {
    /*
    |--------------------------------------------------------------------------
    | Login
    |--------------------------------------------------------------------------
    */
    Route::post('/login', [AuthController::class, 'login']);
    /*
    |--------------------------------------------------------------------------
    | Protected
    |--------------------------------------------------------------------------
    */
    Route::middleware('auth:sanctum')->group(function () {

        // Auth
        Route::post('/logout', [AuthController::class, 'logout']);
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index']);
        // Session
        Route::get('/session/today', [SessionController::class, 'today']);
        Route::get('/session/{session}/students', [SessionController::class, 'students']);
        Route::post('/session/create', [SessionController::class, 'store']);
        // Attendance
        Route::post('/attendance/checkin', [AttendanceController::class, 'checkin']);
        Route::get('/attendance/history', [AttendanceController::class, 'history']);


        Route::post('/attendance/scan', [QrcodeController::class, 'scanAttendance']);
        Route::get('/attendance/today-log', [QrcodeController::class, 'todayLog']);
        Route::get('/attendance/statistic', [QrcodeController::class, 'statistic']);

        // Debug
        Route::get('/test', function (Request $request) {
            return response()->json([
                'user' => $request->user(),
                'guard' => auth()->getDefaultDriver(),
            ]);
        });
    });
});

/*
|--------------------------------------------------------------------------
| User
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
