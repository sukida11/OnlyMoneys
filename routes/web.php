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

Route::group([
    'namespace' => 'App\\Http\\Controllers\\Personal',
    'middleware' => 'auth:sanctum',
    'prefix' => 'personal'
],
    function () {

        Route::get('/', 'IndexController')->name('personal.index');
        Route::get('/edit', 'EditController')->name('personal.edit');
        Route::patch('/update/{user}', 'UpdateController')->name('personal.update');
        Route::get('/verify', 'VerifEmail')->name('personal.email');
        Route::get('/show/{user}', 'ShowController')->name('personal.show');

        Route::group(['namespace' => 'Subscribe'], function () {
            Route::get('/subs', 'IndexController')->name('personal.subs.index');
        });

        Route::group([
            'namespace' => 'Post',
            'prefix' => 'posts'
        ], function () {

            Route::get('/', 'CreateController')->name('personal.post.create');
            Route::post('/', 'StoreController')->name('personal.post.store');
            Route::get('/edit/{post}', 'EditController')->name('personal.post.edit');

        });

    });


