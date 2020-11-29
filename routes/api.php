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


Route::group(['prefix' => 'v1'], function(){

    // Route Client
    Route::group(['prefix' => 'client'], function(){

        // Main Controller

        // Auth Controller

        // Should Login in
        Route::group(['middleware' => 'auth:client'], function(){
            // auth
        });

    });


    // Route Client
    Route::group(['prefix' => 'restaurant'], function(){

        // Auth Controller

        // Should Login in
        Route::group(['middleware' => 'auth:restaurant'], function(){

            // Main Controller

        });

    });
    

});


