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
    Route::get('categories', 'MainController@categories');      // get category
    Route::get('cities', 'MainController@cities');              // get city
    Route::get('regions', 'MainController@regions');            // get regions
    Route::get('setting', 'MainController@setting');            // get setting app 
    Route::get('offers', 'MainController@offers');              // get all offers
    Route::get('restaurants', 'MainController@Restaurants');    // show all restaurants
    Route::any('product', 'MainController@product');            // show list product of restaurant
    Route::post('contact', 'MainController@contact');           // send contact 


    // Route Client
    Route::group(['prefix' => 'client', 'namespace' => 'Client'], function(){

        // Main Controller
        
        
        // Auth Controller
        Route::post('register', 'AuthController@register');                 // Register
        Route::post('login', 'AuthController@login');                       // Login
        Route::post('reset-password', 'AuthController@resetPassword');      // Reset Password
        Route::post('new-password', 'AuthController@newPassword');          // New Password
        Route::post('register-token', 'AuthController@registerToken');      // Register Token
        Route::post('remove-token', 'AuthController@removeToken');          // Remove Token


        // Should Login in
        Route::group(['middleware' => 'auth:client'], function(){

            // Auth Controller
            Route::post('profile', 'AuthController@profile'); //edit profile

            // Main Controller
            Route::post('new-order', 'MainController@newOrder');
            Route::post('decline-order', 'MainController@declineOrder');
            Route::post('deliver-order', 'MainController@deliverOrder');
            Route::post('review', 'MainController@review');
            Route::post('orders', 'MainController@orders');
            Route::post('old-orders', 'MainController@oldOrders');
            Route::get('notifications', 'MainController@notifications');
            
            

        });

    });


    // Route Restaurant
    Route::group(['prefix' => 'restaurant', 'namespace' => 'Restaurant'], function(){

        // Main Controller
        Route::get('categories', 'MainController@categories');

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
            Route::any('notifications', 'MainController@notifications');
            Route::post('acceptOrder', 'MainController@acceptOrder');
            Route::post('rejectOrder', 'MainController@rejectOrder');

        });

    });


});