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

Route::prefix('v1')->group(function () {

    //Routes for authenticate
    //Route for login
    Route::post('/login', 'AuthUserController@login');
    //Route for register
    Route::post('/register', 'AuthUserController@register');
    //Route for forgot password, send the email for the url
    Route::post('/password', 'PasswordController@forgotPassword');

    Route::group(['middleware' => ['jwt.auth']], function () {
        /********* Roles ************/
        //Route for get all roles
        Route::get('/roles', 'RoleController@index');
        //Route for get role by id
        Route::get('/roles/{id}', 'RoleController@show');
        //Route for create a new role
        Route::post('/roles', 'RoleController@store');
        //Route for update a role
        Route::put('/roles/{id}', 'RoleController@update');
        //Route for delete a role
        Route::delete('/roles/{id}', 'RoleController@delete');

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

        /**********Interest Category ********************************/
        //Route for get all interest categories
        Route::get('interest_categories', 'InterestCategoryController@index');
        //Route for get interest categories by id
        Route::get('interest_categories/{id}', 'InterestCategoryController@show');

        /**********  Areas ************/
        //Route for get all areas
        Route::get('areas', ['uses'=>'AreaController@index']);
        //Route for get an area by id
        Route::get('areas/{id}', ['uses'=>'AreaController@show']);
        //Route for create a new area
        Route::post('areas', ['uses'=>'AreaController@store']);
        //Route for update an area
        Route::put('areas/{id}', ['uses'=>'AreaController@update']);
        //Route for delete an area
        Route::delete('areas/{id}', ['uses'=>'AreaController@destroy']);

        /**********  Breakdown ************/
        //Route for get all breakdowns
        Route::get('breakdown', ['uses'=>'BreakdownController@index']);
        //Route for get an breakdown by id
        Route::get('breakdown/{id}', ['uses'=>'BreakdownController@show']);
        //Route for create a new breakdown
        Route::post('breakdown', ['uses'=>'BreakdownController@store']);
        //Route for update an breakdown
        Route::put('breakdown/{id}', ['uses'=>'BreakdownController@update']);
        //Route for delete an breakdown
        Route::delete('breakdown/{id}', ['uses'=>'BreakdownController@destroy']);


        /**********  Notice ************/
        //Route for get all notices
        Route::get('notice', ['uses'=>'NoticeController@index']);
        //Route for get an notice by id
        Route::get('notice/{id}', ['uses'=>'NoticeController@show']);
        //Route for create a new notice
        Route::post('notice', ['uses'=>'NoticeController@store']);
        //Route for update an notice
        Route::put('notice/{id}', ['uses'=>'NoticeController@update']);
        //Route for delete an notice
        Route::delete('notice/{id}', ['uses'=>'NoticeController@destroy']);

        /**********  Tags ************/
        //Route for get all tags
        Route::get('tags', ['uses'=>'TagsController@index']);
        //Route for get an tags by id
        Route::get('tags/{id}', ['uses'=>'TagsController@show']);
        //Route for create a new tags
        Route::post('tags', ['uses'=>'TagsController@store']);
        //Route for update an tags
        Route::put('tags/{id}', ['uses'=>'TagsController@update']);
        //Route for delete an tags
        Route::delete('tags/{id}', ['uses'=>'TagsController@destroy']);

        /**********  Category ************/
        //Route for get all categories
        Route::get('category', ['uses'=>'CategoryController@index']);
        //Route for get an category by id
        Route::get('category/{id}', ['uses'=>'CategoryController@show']);
        //Route for create a new category
        Route::post('category', ['uses'=>'CategoryController@store']);
        //Route for update an category
        Route::put('category/{id}', ['uses'=>'CategoryController@update']);
        //Route for delete an category
        Route::delete('category/{id}', ['uses'=>'CategoryController@destroy']);

        /**********  Enrollment ************/
        //Route for get all enrollment
        Route::get('enrollment', ['uses'=>'MatriculaController@index']);
        //Route for get an enrollment by id
        Route::get('enrollment/{id}', ['uses'=>'MatriculaController@show']);
        //Route for create a new enrollment
        Route::post('enrollment', ['uses'=>'MatriculaController@store']);
        //Route for update an enrollment
        Route::put('enrollment/{id}', ['uses'=>'MatriculaController@update']);
        //Route for delete an enrollment
        Route::delete('enrollment/{id}', ['uses'=>'MatriculaController@destroy']);

        /**********  Public Center ************/
        //Route for get all public center
        Route::get('publiccenter', ['uses'=>'PublicCenterController@index']);
        //Route for get an public center by id
        Route::get('publiccenter/{id}', ['uses'=>'PublicCenterController@show']);
        //Route for create a new public center
        Route::post('publiccenter', ['uses'=>'PublicCenterController@store']);
        //Route for update an public center
        Route::put('publiccenter/{id}', ['uses'=>'PublicCenterController@update']);
        //Route for delete an public center
        Route::delete('publiccenter/{id}', ['uses'=>'PublicCenterController@destroy']);

        /**********  Incidence ************/
        //Route for get all Incidences
        Route::get('incidence', ['uses'=>'IncidenceController@index']);
        //Route for get an incidence by id
        Route::get('incidence/{id}', ['uses'=>'IncidenceController@show']);
        //Route for create a new incidence
        Route::post('incidence', ['uses'=>'IncidenceController@store']);
        //Route for update an incidence
        Route::put('incidence/{id}', ['uses'=>'IncidenceController@update']);
        //Route for delete an incidence
        Route::delete('incidence/{id}', ['uses'=>'IncidenceController@destroy']);

        //Route for logout
        Route::get('/logout', 'AuthUserController@logout');

        Route::group(['middleware' => ['admin']], function () {
        });
    });
});
