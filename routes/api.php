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

Route::post('saveState',['uses'=>'StateController@store'] );

Route::get('showState/{id}',['uses'=>'StateController@show'] );

Route::get('deleteState/{id}',['uses'=>'StateController@destroy'] );





Route::group(['middleware' => ['jwt.auth','admin']], function(){
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

//Routes for authenticate
//Route for login
Route::put('/auth', 'AuthUserController@login');
//Route for register
Route::post('/auth', 'AuthUserController@register');