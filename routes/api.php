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

//Route for get all roles
Route::get('/roles', 'UserRolesController@getRoles' );
//Route for get role by id
Route::get('/roles/{id}', 'UserRolesController@getRoleById' );
//Route for create a new role
Route::post('/roles', 'UserRolesController@createRole' );
//Route for update a role
Route::put('/roles/{id}', 'UserRolesController@updateRole' );
//Route for delete a role
Route::delete('/roles/{id}', 'UserRolesController@deleteRole' );
