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
Route::group(['namespace' => 'Boot', 'prefix' => 'boot','middleware' => ['auth','rbac']], function () {

    //boot index
    Route::get('/', 'IndexController@index') ->name('boot');

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

    //keyword group
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

    //user group
    Route::group(['prefix' => 'user',], function () {

        //index and recover
        Route::get('index/{type?}/{order?}/{search?}', 'UserController@index')->name('user-index');

        //keyword sort
        Route::post('sort', 'UserController@sort')->name('user-sort');

        //create
        Route::get('create', 'UserController@create')->name('user-create');

        //store
        Route::post('store', 'UserController@store')->name('user-store');

        //destroy
        Route::get('destroy/{id}', 'UserController@destroy')->name('user-destroy');

        //restore
        Route::get('restore/{id}', 'UserController@restore')->name('user-restore');

        //edit
        Route::get('edit/{id}', 'UserController@edit')->name('user-edit');

        //update
        Route::post('update', 'UserController@update')->name('user-update');

    });


    //role group
    Route::group(['prefix' => 'role',], function () {

        //index and recover
        Route::get('index/{type?}/{order?}/{search?}', 'RoleController@index')->name('role-index');

        //keyword sort
        Route::post('sort', 'RoleController@sort')->name('role-sort');

        //create
        Route::get('create', 'RoleController@create')->name('role-create');

        //store
        Route::post('store', 'RoleController@store')->name('role-store');

        //destroy
        Route::get('destroy/{id}', 'RoleController@destroy')->name('role-destroy');


        //edit
        Route::get('edit/{id}', 'RoleController@edit')->name('role-edit');

        //update
        Route::post('update', 'RoleController@update')->name('role-update');

        Route::get('auth/{id}', 'RoleController@giveAuth')->name('role-auth');

        Route::post('auth/store', 'RoleController@authStore')->name('role-auth-store');

    });


    //role group
    Route::group(['prefix' => 'permission',], function () {

        //index and recover
        Route::get('index/{type?}/{order?}/{search?}', 'PermissionController@index')->name('permission-index');

        //keyword sort
        Route::post('sort', 'PermissionController@sort')->name('permission-sort');

        //create
        Route::get('create', 'PermissionController@create')->name('permission-create');

        //store
        Route::post('store', 'PermissionController@store')->name('permission-store');

        //destroy
        Route::get('destroy/{id}', 'PermissionController@destroy')->name('permission-destroy');


        //edit
        Route::get('edit/{id}', 'PermissionController@edit')->name('permission-edit');

        //update
        Route::post('update', 'PermissionController@update')->name('permission-update');

    });


}) ;


//Api group
Route::group(['namespace' => 'Api', 'prefix' => 'api',], function () {

    //upload localhost image
    Route::post('/upload-localhost', 'UploadController@localhost')->name('upload-localhost');

    //upload aliyunOss image
    Route::post('/upload-aliyun', 'UploadController@aliyun')->name('upload-aliyun');

});
