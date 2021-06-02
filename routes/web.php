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
    return redirect('/home');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//Routes resources for category
Route::resource('category', 'CategoryController', [
    'only' => [
        'index','store','show','update','destroy'
    ]
]);

//Routes resources for users
Route::resource('users', 'UserController', [
    'only' => [
        'index','store','show','update','destroy'
    ]
]);

//Routes resources for public centers
Route::resource('public_center', 'PublicCenterController', [
    'only' => [
        'index','store','show','update','destroy'
    ]
]);

//Routes resources for matriculas
Route::resource('matriculas', 'MatriculaController', [
    'only' => [
        'index','store','show','update','destroy'
    ]
]);

Route::get('/token', 'CategoryController@getToken');
