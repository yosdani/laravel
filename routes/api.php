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
Route::post('/password', 'PasswordController@forgotPassword');

Route::group(['middleware' => ['jwt.auth','admin']], function () {
    //Routes for roles
    //Route for get all roles
    Route::get('/roles', 'RoleController@getRoles');
    //Route for get role by id
    Route::get('/roles/{id}', 'RoleController@getRoleById');
    //Route for create a new role
    Route::post('/roles', 'RoleController@createRole');
    //Route for update a role
    Route::put('/roles/{id}', 'RoleController@updateRole');
    //Route for delete a role
    Route::delete('/roles/{id}', 'RoleController@deleteRole');
    //Route for  create new state
    Route::post('saveState', ['uses'=>'StateController@store']);
    //Route for get state by id
    Route::get('showState/{id}', ['uses'=>'StateController@show']);
    //Route for delete state
    Route::get('deleteState/{id}', ['uses'=>'StateController@destroy']);


    //Route for logout
    Route::delete('/auth', 'AuthUserController@logout');

    Route::group(['middleware' => ['admin']], function () {
        //Routes for roles
        //Route for get all roles
        Route::get('/roles', 'RoleController@getRoles');
        //Route for get role by id
        Route::get('/roles/{id}', 'RoleController@getRoleById');
        //Route for create a new role
        Route::post('/roles', 'RoleController@createRole');
        //Route for update a role
        Route::put('/roles/{id}', 'RoleController@updateRole');
        //Route for delete a role
        Route::delete('/roles/{id}', 'RoleController@deleteRole');
    });
});
