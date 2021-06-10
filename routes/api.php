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

    Route::group(['middleware' => ['authJWT']], function () {

        /**********Interest Category ********************************/
        //Route for get all interest categories
        Route::get('interest_categories', 'InterestCategoryController@index');
        //Route for get interest categories by id
        Route::get('interest_categories/{id}', 'InterestCategoryController@show');

        

        


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
       

        /**********  Incidence ************/
        //Route for get all Incidences
        Route::get('incidence', ['uses'=>'Api\IncidenceController@index']);
        //Route for get an incidence by id
        Route::get('incidence/{id}', ['uses'=>'Api\IncidenceController@show']);
        //Route for create a new incidence
        Route::post('incidence', ['uses'=>'Api\IncidenceController@store']);
        //Route for update an incidence
        Route::put('incidence/{id}', ['uses'=>'Api\IncidenceController@update']);
        //Route for delete an incidence
        Route::delete('incidence/{id}', ['uses'=>'Api\IncidenceController@destroy']);

        //Route for logout
        Route::get('/logout', 'AuthUserController@logout');

        Route::group(['middleware' => ['admin']], function () {
        });
    });
});
