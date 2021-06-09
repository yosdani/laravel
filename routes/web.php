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

Route::get('/', 'HomeController@index')->name('home')->middleware('auth');

Route::group(['middleware'=>['web','auth','admin']], function(){
    Route::prefix('admin')->group(function () {
        //Routes resources for Incidence
        Route::resource('incidences', 'IncidenceController', [
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
    
    });
    
    
    //Routes resources for category
    Route::resource('category', 'CategoryController', [
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
    
    //Routes resources for interest categories, the index methods are in api route
    Route::resource('interest_categories', 'InterestCategoryController', [
        'only' => [
            'store','update','destroy'
        ]
    ]);

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
});


Route::get('/token', 'CategoryController@getToken');
