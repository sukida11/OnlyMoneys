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
    return new \App\Http\Resources\Person\PersonResource($request->user());
});


Route::group([

    'prefix' => 'posts',
    'namespace' => 'App\\Http\\Controllers\\Personal\\Post'

], function () {

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

Route::group([

    'namespace' => 'App\\Http\\Controllers\\Personal',
    'prefix' => 'personal'

], function () {

    Route::get('/find', 'FindPersonController');

    Route::group(['namespace' => 'Subscribe', 'prefix' => 'subs', 'middleware' => 'auth:sanctum'], function () {
        Route::get('/', 'GetSubscribesController');
    });

});


Route::group([

    'namespace' => 'App\\Http\\Controllers\\Post',
    'prefix' => 'show'

], function () {
    Route::get('/{user}', 'IndexController');
    Route::post('/like/{post}', 'LikeController');
    Route::get('/load_with_limit/{user}', 'LoadPostsWithLimit');
    Route::get('/likes/{user}', 'LikedPostsController');
});

Route::group([
    'namespace' => 'App\\Http\\Controllers\\Subscriber',
    'prefix' => 'subs',
    'middleware' => ['auth:sanctum', 'verified']
], function () {
    Route::post('/subscribe/{user}', 'SubscribeController');
});

