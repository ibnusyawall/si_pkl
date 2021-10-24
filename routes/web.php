<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/*
Route::group(['prefix' => 'auth'], function() {
    Route::get('login', function() {
        return view('layouts/auth/login');
    });
});
*/
/*Route::group(['prefix' => 'dashboard', 'middleware' => ['api.checkTokenWeb', 'web']], function() {
    Route::get('test', function() {
        return response()->json(['status' => 'success', 'message' => 'authorized token.']);
    });
});
*/
/*Route::get('/auth/{any}', function () {
    return view('layouts/auth/login');;
})->where('any', '.*');
*/
/*Route::get('/dashboard/{any}', function () {
    return view('layouts/dashboard/index');;
})->where('any', '.*');
*/

Route::get('/{any}', function () {
    return view('dash');
})->where('any', '.*');

