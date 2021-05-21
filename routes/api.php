<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Routes for authenticate
//Route for login
Route::put('/auth', 'AuthUserController@login');
//Route for register
Route::post('/auth', 'AuthUserController@register');
//Route for forgot password, send the email for the url
//Example: /auth?email=example@gmail.com
Route::get('/auth', 'AuthUserController@forgotPassword');

Route::group(['middleware' => ['jwt.auth','admin']], function(){

    //Route for logout
    Route::delete('/auth', 'AuthUserController@logout');

    Route::group(['middleware' => ['admin']], function(){
        //Routes for roles
        //Route for get all roles
        Route::get('/roles', 'RoleController@getRoles' );
        //Route for get role by id
        Route::get('/roles/{id}', 'RoleController@getRoleById' );
        //Route for create a new role
        Route::post('/roles', 'RoleController@createRole' );
        //Route for update a role
        Route::put('/roles/{id}', 'RoleController@updateRole' );
        //Route for delete a role
        Route::delete('/roles/{id}', 'RoleController@deleteRole' );
    });
});