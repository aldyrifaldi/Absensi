<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('detail-absensi', 'DetailAbsensiController');
Route::resource('absen', 'AbsenController');
Route::post('jadwal-absensi/store', 'ApiController@inputJadwal');
Route::post('absensi/create', 'ApiController@absensi');
Route::get('jadwal-absensi', 'ApiController@jadwalAbsensi');
Route::get('jadwal-perkelas/{id_kelas}', 'ApiController@jadwalAbsensiPerKelas');
Route::get('kelas', 'ApiController@kelas');
Route::get('data-absen-santri/{kelas}/{tanggal}', 'ApiController@dataAbsenSantri');
Route::get('data-absensi/{kelas}', 'ApiController@dataAbsensi');
Route::post('alasan/store', 'ApiController@alasanSantri');
