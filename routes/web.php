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

    //Routes resources for streets, the index methods are in api route
    Route::resource('street', 'StreetController', [
        'only' => [
            'index', 'store', 'show', 'update', 'destroy',
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
});


Route::get('/token', 'CategoryController@getToken');
