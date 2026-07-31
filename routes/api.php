<?php

use App\Http\Controllers\Api\ApiGuruController;
use App\Http\Controllers\Api\ApiSiswaController;
use App\Http\Controllers\Api\AttendanceController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\SessionController;
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

    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {

        Route::post('/logout', [AuthController::class, 'logout']);

        Route::get('/dashboard', [DashboardController::class, 'index']);

        Route::get('/session/today', [SessionController::class, 'today']);

        Route::get('/session/{session}/students', [SessionController::class, 'students']);

        // TAMBAHKAN DI SINI
        Route::post('/session/create', [SessionController::class, 'store']);

        Route::post('/attendance/checkin', [AttendanceController::class, 'checkin']);

        Route::get('/attendance/history', [AttendanceController::class, 'history']);
    });
});

/*
|--------------------------------------------------------------------------
| Default Sanctum User
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
