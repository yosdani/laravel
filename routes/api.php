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

Route::group(['middleware' => ['jwt.auth']], function () {
    /********* Roles ************/
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

    /********* States ************/
    //Route for  all states
    Route::get('states', ['uses'=>'StateController@index']);
    //Route for  create new state
    Route::post('states', ['uses'=>'StateController@store']);
    //Route for  update a state
    Route::put('states/{id}', ['uses'=>'StateController@update']);
    //Route for get state by id
    Route::get('states/{id}', ['uses'=>'StateController@show']);
    //Route for delete state
    Route::delete('states/{id}', ['uses'=>'StateController@destroy']);

    /**********  Areas ************/
    //Route for get all areas
    Route::get('/areas', 'AreaController@index');
    //Route for get an area by id
    Route::get('/areas/{id}', 'AreaController@show');
    //Route for create a new area
    Route::post('/areas', 'AreaController@store');
    //Route for update an area
    Route::put('/areas/{id}', 'AreaController@update');
    //Route for delete an area
    Route::delete('/areas/{id}', 'AreaController@delete');

    //Route for logout
    Route::get('/logout', 'AuthUserController@logout');

    Route::group(['middleware' => ['admin']], function () {
    });
});
