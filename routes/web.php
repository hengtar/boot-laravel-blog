<?php

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

Route::get('/', function () {
    return view('welcome');
});


Route::group(['namespace' => 'Boot', 'prefix' => 'boot',], function () {

    Route::get('/', 'IndexController@index');

    Route::get('/show', 'IndexController@show')->name('show');

    //文章管理
    Route::group(['prefix' => 'article',], function () {

        Route::get('/index', 'ArticleController@index')->name('article-index');
        Route::get('/create', 'ArticleController@create')->name('article-create');
        Route::post('/store', 'ArticleController@store')->name('article-store');


    });


});

