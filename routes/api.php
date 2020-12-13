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

Route::group(['middleware' => ['cors', 'json.response']], function () {
    Route::middleware(['auth:api', 'api.admin'])->group(function () {
        Route::post('/register','App\Http\Controllers\Auth\ApiAuthController@register')->name('register.api');
        Route::prefix('/users')->middleware(['api.admin', 'auth:api'])->group(function () {
            Route::get('/', 'App\Http\Controllers\UserController@getUsers');
            Route::get('/{user_id}', 'App\Http\Controllers\UserController@get');
            Route::put('/{user_id}', 'App\Http\Controllers\UserController@update');
            Route::delete('/{user_id}', 'App\Http\Controllers\UserController@destroy');
        });

        Route::put('articles/{article_id}', 'App\Http\Controllers\ArticleController@update');
        Route::delete('articles/{article_id}', 'App\Http\Controllers\ArticleController@destroy');
        Route::post('articles/create', 'App\Http\Controllers\ArticleController@create');

    });
    Route::post('/login', 'App\Http\Controllers\Auth\ApiAuthController@login')->name('login.api');

});

Route::get('articles/', 'App\Http\Controllers\ArticleController@getArticles');
Route::get('articles/{article_id}', 'App\Http\Controllers\ArticleController@get');


Route::middleware('auth:api')->group(function () {
    // our routes to be protected will go in here
    Route::post('/logout', 'App\Http\Controllers\Auth\ApiAuthController@logout')->name('logout.api');
});
