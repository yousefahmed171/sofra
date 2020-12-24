<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::group(['prefix' => 'v1', 'namespace' => 'Api'], function(){


    // Main Controller 
    Route::get('categories', 'MainController@categories');
    Route::get('cities', 'MainController@cities');
    Route::get('regions', 'MainController@regions');


    // Route Client
    Route::group(['prefix' => 'client', 'namespace' => 'Client'], function(){

        // Main Controller

        // Auth Controller
        Route::post('register', 'AuthController@register');
        Route::post('login', 'AuthController@login');
        Route::post('reset-password', 'AuthController@resetPassword');
        Route::post('new-password', 'AuthController@newPassword');
        Route::post('register-token', 'AuthController@registerToken');
        Route::post('remove-token', 'AuthController@removeToken');
        Route::get('get-clients', 'AuthController@getClients');

        // Should Login in
        Route::group(['middleware' => 'auth:client'], function(){

            // Auth Controller
            Route::post('profile', 'AuthController@profile');

            // Main Controller
            Route::post('new-order', 'MainController@newOrder');
            Route::post('decline-order', 'MainController@declineOrder');

            

        });

    });


    // Route Restaurant
    Route::group(['prefix' => 'restaurant', 'namespace' => 'Restaurant'], function(){

        // Main Controller


        // Auth Controller
        Route::post('register', 'AuthController@register');
        Route::post('login', 'AuthController@login');
        Route::post('reset-password', 'AuthController@resetPassword');
        Route::post('new-password', 'AuthController@newPassword');
        Route::post('register-token', 'AuthController@registerToken');
        Route::post('remove-token', 'AuthController@removeToken');
        Route::get('get-restaurants', 'AuthController@getRestaurants');

        // Should Login in
        Route::group(['middleware' => 'auth:restaurant'], function(){

            // Auth Controller
            Route::post('profile', 'AuthController@profile');



            // Main Controller
            Route::post('products', 'MainController@products');
            Route::post('offers', 'MainController@offers');

        });

    });


});