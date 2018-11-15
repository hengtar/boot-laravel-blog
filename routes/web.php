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




Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');



//Boot group
Route::group(['namespace' => 'Boot', 'prefix' => 'boot','middleware' => 'auth'], function () {

    //boot index
    Route::get('/', 'IndexController@index') ;

    //boot show main page
    Route::get('/show', 'IndexController@show')->name('show');

    //article group
    Route::group(['prefix' => 'article'], function () {

        //index and recover
        Route::get('index/{recover?}/{type?}/{order?}/{search?}', 'ArticleController@index')->name('article-index');

        //article sort
        Route::post('sort', 'ArticleController@sort')->name('article-sort');

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

        //update
        Route::post('update', 'ArticleController@update')->name('article-update');

    }) ;

    //category group
    Route::group(['prefix' => 'category',], function () {

        //index and recover
        Route::get('index/{recover?}/{type?}/{order?}/{search?}', 'CategoryController@index')->name('category-index');

        //article sort
        Route::post('sort', 'CategoryController@sort')->name('category-sort');

        //create
        Route::get('create', 'CategoryController@create')->name('category-create');

        //store
        Route::post('store', 'CategoryController@store')->name('category-store');

        //destroy
        Route::get('destroy/{id}', 'CategoryController@destroy')->name('category-destroy');

        //ForceDelete
        Route::get('ForceDelete/{id}', 'CategoryController@deleteForce')->name('category-ForceDelete');

        //restore
        Route::get('restore/{id}', 'CategoryController@restore')->name('category-restore');

        //edit
        Route::get('edit/{id}', 'CategoryController@edit')->name('category-edit');

        //update
        Route::post('update', 'CategoryController@update')->name('category-update');

    });

    //article group
    Route::group(['prefix' => 'keyword',], function () {

        //index and recover
        Route::get('index/{recover?}/{type?}/{order?}/{search?}', 'KeywordController@index')->name('keyword-index');

        //keyword sort
        Route::post('sort', 'KeywordController@sort')->name('keyword-sort');

        //create
        Route::get('create', 'KeywordController@create')->name('keyword-create');

        //store
        Route::post('store', 'KeywordController@store')->name('keyword-store');

        //destroy
        Route::get('destroy/{id}', 'KeywordController@destroy')->name('keyword-destroy');

        //ForceDelete
        Route::get('ForceDelete/{id}', 'KeywordController@deleteForce')->name('keyword-ForceDelete');

        //restore
        Route::get('restore/{id}', 'KeywordController@restore')->name('keyword-restore');

        //edit
        Route::get('edit/{id}', 'KeywordController@edit')->name('keyword-edit');

        //update
        Route::post('update', 'KeywordController@update')->name('keyword-update');

    });

    //category group
    Route::group(['prefix' => 'config',], function () {

        //seo
        Route::get('seo', 'ConfigController@seo')->name('config-seo');
        Route::post('store', 'ConfigController@store')->name('config-store');

        Route::get('admin', 'ConfigController@admin')->name('config-admin');

    });

}) ;


//Api group
Route::group(['namespace' => 'Api', 'prefix' => 'api',], function () {

    //upload localhost image
    Route::post('/upload-localhost', 'UploadController@localhost')->name('upload-localhost');

    //upload aliyunOss image
    Route::post('/upload-aliyun', 'UploadController@aliyun')->name('upload-aliyun');

});
