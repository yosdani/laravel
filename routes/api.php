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

        /**********  News ************/
        //Route for get all notices
        Route::get('news', ['uses'=>'NewsController@index']);
        //Route for get an notice by id
        Route::get('news/{id}', ['uses'=>'NewsController@show']);

        /**********  Category ************/
        //Route for get all categories
        Route::get('category', ['uses'=>'Api/CategoryController@index']);
        //Route for get an category by id
        Route::get('category/{id}', ['uses'=>'Api/CategoryController@show']);
       

        /**********  Incidence ************/
        //Route for get all Incidences by user
        Route::get('incidence', ['uses'=>'Api\IncidenceController@index']);
        //Route for get an incidence by id
        Route::get('incidence/{id}', ['uses'=>'Api\IncidenceController@show']);
        //Route for create a new incidence
        Route::post('incidence', ['uses'=>'Api\IncidenceController@store']);
        //Route for update an incidence
        Route::put('incidence/{id}', ['uses'=>'Api\IncidenceController@update']);
        //Route for get all incidences of workers
        Route::get('worker/incidence',['uses'=>'Api\IncidenceController@indexWorkers']);

        /**********  Subscription ************/
        //Route Create a new subcription
        Route::post('subscription', ['uses'=>'Api\SubcriptionController@toSubscribe']);
        //Route Create a new subcription
        Route::delete('subscription/{id}', ['uses'=>'Api\SubcriptionController@destroy']);

        /**********  firebase ************/

        Route::post('/fcm/token', 'NotificationsController@postToken');
        Route::post('/fcm/send', 'NotificationsController@sendAll');



        //Route for logout
        Route::get('/logout', 'AuthUserController@logout');

        Route::group(['middleware' => ['admin']], function () {
        });
    });



});
