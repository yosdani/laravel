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

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::prefix('admin')->group(function () {
    //Routes resources for Incidence
    Route::resource('incidences', 'IncidenceController', [
        'only' => [
            'index', 'store', 'show', 'update', 'destroy',
        ],
    ]);

});


//Routes resources for category
Route::resource('category', 'CategoryController', [
    'only' => [
        'index', 'store', 'show', 'update', 'destroy',
    ],
]);

//Routes resources for users
Route::resource('users', 'UserController', [
    'only' => [
        'index', 'store', 'show', 'update', 'destroy',
    ],
]);

//Routes resources for public centers
Route::resource('public_center', 'PublicCenterController', [
    'only' => [
        'index', 'store', 'show', 'update', 'destroy',
    ],
]);

//Routes resources for matriculas
Route::resource('matriculas', 'MatriculaController', [
    'only' => [
        'index', 'store', 'show', 'update', 'destroy',
    ],
]);

Route::get('/token', 'CategoryController@getToken');
