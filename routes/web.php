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

    //article group
    Route::group(['prefix' => 'article',], function () {

        //index and recover
        Route::get('index/{recover?}', 'ArticleController@index')->name('article-index');
        //create
        Route::get('create', 'ArticleController@create')->name('article-create');
        //store
        Route::post('store', 'ArticleController@store')->name('article-store');
        //destroy
        Route::get('destroy/{id}', 'ArticleController@destroy')->name('article-destroy');
        //ForceDelete
        Route::get('ForceDelete/{id}', 'ArticleController@deleteForce')->name('article-ForceDelete');
        //restore
        Route::get('restore/{id}', 'ArticleController@restore')->name('article-restore');
        //edit
        Route::get('edit/{id}', 'ArticleController@edit')->name('article-edit');

    });


});

Route::group(['namespace' => 'Api', 'prefix' => 'api',], function () {

    Route::post('/upload-localhost', 'UploadController@localhost')->name('upload-localhost');

});



