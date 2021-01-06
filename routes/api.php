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
        Route::get('categories',            'MainController@categories');           // get category
        Route::get('cities',                'MainController@cities');               // get city
        Route::get('regions',               'MainController@regions');              // get regions
        Route::get('setting',               'MainController@setting');              // get setting app 
        Route::get('offers',                'MainController@offers');               // get all offers
        Route::get('restaurants',           'MainController@restaurants');          // show all restaurants
        Route::any('product',               'MainController@product');              // show list product of restaurant
        Route::post('contact',              'MainController@contact');              // send contact 


    // Route Client
    Route::group(['prefix' => 'client', 'namespace' => 'Client'], function(){        
        
        // Auth Controller
        Route::post('register',             'AuthController@register');             // Register
        Route::post('login',                'AuthController@login');                // Login
        Route::post('reset-password',       'AuthController@resetPassword');        // Reset Password
        Route::post('new-password',         'AuthController@newPassword');          // New Password
        Route::post('register-token',       'AuthController@registerToken');        // Register Token
        Route::post('remove-token',         'AuthController@removeToken');          // Remove Token

        // Must be checked Login in
        Route::group(['middleware' => 'auth:client'], function(){

            // Auth Controller
            Route::post('profile',          'AuthController@profile');              // Edit profile

            // Main Controller
            Route::post('new-order',        'MainController@newOrder');             // Create New Order
            Route::post('decline-order',    'MainController@declineOrder');         // client decline order
            Route::post('deliver-order',    'MainController@deliverOrder');         // client deliver order
            Route::post('review',           'MainController@review');               // add review
            Route::post('orders',           'MainController@orders');               // show all order panding
            Route::post('old-orders',       'MainController@oldOrders');            // show order deliver
            Route::get('notifications',     'MainController@notifications');        // get all notifications with user

        });

    });


    // Route Restaurant
    Route::group(['prefix' => 'restaurant', 'namespace' => 'Restaurant'], function(){

        // Auth Controller
        Route::post('register',             'AuthController@register');             // Register
        Route::post('login',                'AuthController@login');                // Login
        Route::post('reset-password',       'AuthController@resetPassword');        // Reset Password   
        Route::post('new-password',         'AuthController@newPassword');          // New Password
        Route::post('register-token',       'AuthController@registerToken');        // Register Token
        Route::post('remove-token',         'AuthController@removeToken');          // Remove Token

        // Must be checked Login in
        Route::group(['middleware' => 'auth:restaurant'], function(){

            // Auth Controller
            Route::post('profile',          'AuthController@profile');              // Edit profile 

            // Main Controller
            Route::get('products',          'MainController@products');             // get all products
            Route::post('add-product',      'MainController@addProduct');           // create new product
            Route::post('edit-product',     'MainController@editProduct');          // edit new product
            Route::post('delete-product',   'MainController@deleteProduct');        // delete new product
            Route::get('offers',            'MainController@offers');               // get all offers
            Route::post('add-offer',        'MainController@addOffer');             // create new offer
            Route::post('edit-offer',       'MainController@editOffer');            // edit  offer
            Route::post('delete-offer',     'MainController@deleteOffer');          // delete  offer
            Route::post('orders',           'MainController@orders');               // get Order with restaurant
            Route::post('accept-order',     'MainController@acceptOrder');          // accept Order
            Route::post('reject-order',     'MainController@rejectOrder');          // reject Order
            Route::post('receipt-order',    'MainController@receiptOrder');         // receipt Order 
            Route::any('notifications',     'MainController@notifications');        // get all notifications
            Route::post('commissions',      'MainController@commissions');          // view commissions

        });

    });

});