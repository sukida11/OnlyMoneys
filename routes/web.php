<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', 'App\\Http\\Controllers\\Main\\IndexController')->name('main.index');

Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(
    [

        'namespace' => 'App\\Http\\Controllers\\Personal',
        'middleware' => 'auth',
        'prefix' => 'personal'

    ],
    function () {
        Route::get('/', 'IndexController')->name('personal.index');
        Route::get('/edit', 'EditController')->name('personal.edit');
        Route::patch('/update/{user}', 'UpdateController')->name('personal.update');
        Route::get('/verify', 'VerifEmail')->name('personal.email');
});
