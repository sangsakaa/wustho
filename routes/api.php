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
    /*
    |--------------------------------------------------------------------------
    | Authentication
    |--------------------------------------------------------------------------
    */
    Route::post('/login', [AuthController::class, 'login']);

    /*
    |--------------------------------------------------------------------------
    | Protected Routes
    |--------------------------------------------------------------------------
    */

    Route::middleware('auth:sanctum')->group(function () {

        Route::post('/logout', [AuthController::class, 'logout']);

        Route::get('/dashboard', [DashboardController::class, 'index']);

        // Session
        Route::get('/session/today', [SessionController::class, 'today']);
        Route::get('/session/{session}/students', [SessionController::class, 'students']);

        // Attendance
        Route::post('/attendance/checkin', [AttendanceController::class, 'checkin']);
        Route::get('/attendance/history', [AttendanceController::class, 'history']);

        /*
        |--------------------------------------------------------------------------
        | Debug (hapus saat production)
        |--------------------------------------------------------------------------
        */
        Route::get('/test', function (Request $request) {
            return response()->json([
                'guard_default' => config('auth.defaults.guard'),
                'guard_used'    => auth()->getDefaultDriver(),
                'check'         => auth()->check(),
                'user'          => auth()->user(),
                'request_user'  => $request->user(),
                'bearer'        => $request->bearerToken(),
            ]);
        });
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
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/session/create', [SessionController::class, 'store']);
});
