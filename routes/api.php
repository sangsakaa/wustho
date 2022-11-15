<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiSiswaController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();

});
Route::get('siswa', [ApiSiswaController::class, 'index'])->name('siswa');
Route::get('siswa/{siswa}', [ApiSiswaController::class, 'show']);
Route::post('siswa', [ApiSiswaController::class, 'store']);
Route::get('siswa/{siswa}/edit', [ApiSiswaController::class, 'edit']);
Route::patch('siswa/{siswa}', [ApiSiswaController::class, 'update']);
Route::delete('siswa/{siswa}', [ApiSiswaController::class, 'destroy']);
