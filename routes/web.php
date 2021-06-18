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
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::get('/', 'HomeController@index')->name('home')->middleware('auth');

Route::group(['middleware'=>['web','auth','admin']], function () {
    Route::prefix('admin')->group(function () {
        Route::post('change-password', ['uses'=>'PasswordController@changeAdminPassword']);
        //Routes resources for Incidence
        Route::resource('incidences', 'IncidenceController', [
            'only' => [
                'index', 'store', 'show', 'update', 'destroy',
            ],
        ]);

        //Route for news
        Route::resource('news', 'NewsController',[
            'only' => [
                'index', 'store', 'show', 'update', 'destroy'
            ]
        ]);
    
        //Routes resources for users
        Route::resource('users', 'UserController', [
            'only' => [
                'index', 'store', 'show', 'update', 'destroy',
            ],
        ]);
        //Route for get all user with rol responsables
        Route::get('responsables/areas','UserController@getResponsables');
        //Route for get all user with rol worker
        Route::get('workers', 'UserController@getWorkers');
        //Route to get workers without areas
        Route::get('workers/select','UserController@workersWithoutArea');

        /********* Roles ************/
        Route::resource('roles', 'RoleController');

        //Routes resources for category
        Route::resource('category', 'CategoryController', [
            'only' => [
                'index', 'store', 'show', 'update', 'destroy',
            ],
        ]);
        // Route for get all categories
        Route::get('all/categories','CategoryController@all');


        //Routes resources for public centers
        Route::resource('public_center', 'PublicCenterController', [
            'only' => [
                'index', 'store', 'show', 'update', 'destroy',
            ],
        ]);

        //Routes resources for matriculas
        Route::resource('enrollment', 'EnrolmentController', [
            'only' => [
                'index', 'store', 'show', 'update', 'destroy',
            ],
        ]);

        //Routes resources for district, the index methods are in api route
        Route::resource('district', 'DistrictController', [
            'only' => [
                'index', 'store', 'show', 'update', 'destroy',
            ]
        ]);

    //Routes resources for streets, the index methods are in api route
    Route::resource('street', 'StreetController', [
        'only' => [
            'index', 'store', 'show', 'update', 'destroy',
        ]
    ]);

    //Routes resources for neighborhood, the index methods are in api route
    Route::resource('neighborhood', 'NeighborhoodController', [
        'only' => [
            'index', 'store', 'show', 'update', 'destroy',
        ]
    ]);

    /********* States ************/
    //Route for  all states
    Route::resource('states', 'StateController', [
        'only' => [
            'index', 'store', 'show', 'update', 'destroy',
        ]
    ]);
    // Route for get all states
    Route::get('all/states','StateController@all');

    /**********  Areas ************/
    //Route for get all areas
    Route::resource('areas', 'AreaController');

    //Route to add workers to area
    Route::post('workers/area/{id}', 'AreaController@addWorker');

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

    /**********  Tags ************/
    Route::resource('tags','TagsController');
    // Route for get all tags
    Route::get('all/tags','TagsController@all');

    /**********  Incidence ************/
    //Route for get all Incidences
    Route::get('incidence', 'IncidenceController@index');
    //Route for get an incidence by id
    Route::get('incidence/{id}', 'IncidenceController@show');
    //Route for create a new incidence
    //Route::post('incidence', 'IncidenceController@store');
    //Route for update an incidence
    Route::put('incidence/{id}', 'IncidenceController@update');
    //Route for delete an incidence
    Route::delete('incidence/{id}', 'Api\IncidenceController@destroy');

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

    //Route for get datas of dashboard bar graphic
    Route::get('dashboard/bar', 'DashboardController@bar');
    //Route for get datas of dashboard radar graphic
    Route::get('dashboard/radar', 'DashboardController@radar');
    //Route for get datas of dashboard responsable and workers
    Route::get('dashboard/teams', 'DashboardController@teams');
    });
});


Route::get('/token', 'CategoryController@getToken');
