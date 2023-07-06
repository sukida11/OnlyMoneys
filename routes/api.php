<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['prefix' => 'posts', 'namespace' => 'App\\Http\\Controllers\\Personal\\Post'], function () {
    Route::post('/', 'StoreController');
    Route::get('/', 'IndexController');
    Route::get('/{post}', 'ShowController');
    Route::patch('/{post}', 'UpdateController');
    Route::delete('/{post}', 'DestroyController');
});
Route::get('/paid', 'App\\Http\\Controllers\\Personal\\Post\\GetPostPaidOrFreeController');

Route::group([

    'namespace' => 'App\\Http\\Controllers\\Like',
    'middleware' => 'auth:sanctum',
    'prefix' => 'likes'

], function () {

    Route::get('/', 'IndexController');

});
