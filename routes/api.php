<?php

use App\Http\Controllers\Api\ApiGuruController;
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
// Api getDataSiswa
Route::get('getDataSiswa', [ApiSiswaController::class, 'getDataSiswa'])->name('getDataSiswa');




Route::get('data-asrama', [ApiSiswaController::class, 'dataAsrama'])->name('data-asrama');
// Api guru
Route::get('data-guru', [ApiGuruController::class, 'dataGuru'])->name('data-guru');