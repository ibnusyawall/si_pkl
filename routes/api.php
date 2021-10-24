<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['prefix' => 'oauth'], function() {
    Route::post('register', 'API\LoginController@register');
    Route::post('login', 'API\LoginController@login');
});

Route::group(['prefix' => 'v1', 'middleware' => 'auth:api'], function() {
    Route::get('check', 'API\BaseController@check');
    Route::get('getuser', 'API\SekolahController@getUser');

    Route::get('sekolah/data', 'API\SekolahController@getAll'); // get all data sekolah
    Route::post('sekolah/siswa', 'API\SekolahController@getSiswa'); // get data sekolah include siswa by npsn
    Route::post('sekolah/tambah', 'API\SekolahController@store'); // add sekolah
    Route::delete('sekolah/delete/{id}', 'API\SekolahController@delete'); // delete sekolah
    Route::post('sekolah/update/{id}', 'API\SekolahController@update'); // update sekolah

    Route::get('siswa/all', 'API\SiswaController@getAll'); // get all siswa data
    Route::get('siswa/{id}', 'API\SiswaController@get'); // get data siswa by nis
    Route::get('siswa/kehadiran/{id}', 'API\SiswaController@kehadiran'); // get all data kehadiran siswa by nis
    Route::post('siswa/tambah', 'API\SiswaController@store'); // add siswa
    Route::post('siswa/update/{id}', 'API\SiswaController@update'); // updata siswa
    Route::delete('siswa/delete/{id}', 'API\SiswaController@delete'); // delete siswa

    Route::get('absen/{id}', 'API\AbsenController@get');  //get data absen by id
    Route::post('absen/tambah', 'API\AbsenController@store'); // add data absen
    Route::post('absen/update/{id}', 'API\AbsenController@update'); // update data absen by id
    Route::delete('absen/delete/{id}', 'API\AbsenController@delete'); // delete absen by id

    Route::get('penilaian/nis/{nis}', 'API\PenilaianController@getByNis'); // get data nilai by nis
    Route::get('penilaian/id/{id}', 'API\PenilaianController@getById');  // get data nilai by id
    Route::post('penilaian/tambah', 'API\PenilaianController@store');  // add data nilai
    Route::post('penilaian/update/{id}', 'API\PenilaianController@update');  // update data nilai by id 
    Route::delete('penilaian/delete/nis/{nis}', 'API\PenilaianController@deleteByNis');  // delete data nilai by nis 
    Route::delete('penilaian/delete/id/{id}', 'API\PenilaianController@deleteById');  // delete data nilai by id .

    Route::get('jurnal/id/{id}', 'API\JurnalController@getId');
    Route::get('jurnal/nis/{nis}', 'API\JurnalController@getNis');
    Route::post('jurnal/tambah', 'API\JurnalController@store');
    Route::post('jurnal/update/{id}', 'API\JurnalController@update');
    Route::delete('jurnal/delete/nis/{nis}', 'API\JurnalController@deleteByNis');
    Route::delete('jurnal/delete/id/{id}', 'API\JurnalController@deleteById');

    Route::get('user/all', 'API\UserController@getAll');
    Route::get('user/{user}', 'API\UserController@showuser');
    Route::post('user/update', 'API\UserController@update');
    Route::delete('user/delete/{id}', 'API\UserController@delete');
});

// v2 is public route
Route::group(['prefix' => 'v2'], function() {
    Route::get('sekolah/data', 'API\SekolahController@getAll');
    Route::post('user/tambah', 'API\LoginController@register');
    Route::post('siswa/tambah', 'API\SiswaController@store');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
